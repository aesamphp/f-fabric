<?php

namespace App\Models;

use DB;

class DiscountCode extends AppModel
{

	const CSV_DESTINATION_PATH = 'downloads/bulk-discount-codes';
	const USE_LIMIT_SINGLE = 1;
	const USE_LIMIT_MULTIPLE = 2;
	const USE_LIMIT_UNLIMITED = 3;
	const DATE_LIMIT_LIMITED = 1;
	const DATE_LIMIT_UNLIMITED = 2;
	const VALUE_TYPE_AMOUNT = 1;
	const VALUE_TYPE_PERCENTAGE = 2;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'discount_codes';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['code', 'use_limit_id', 'use_limit', 'date_limit_id', 'from_date', 'to_date', 'value_type_id', 'value', 'min_value', 'quantity', 'group_id'];

	/**
	 * The attributes that are nullable by default.
	 *
	 * @var array
	 */
	protected $nullable = ['use_limit', 'from_date', 'to_date', 'min_value', 'quantity', 'group_id'];

	/**
	 * The attributes that should be cast to native types.
	 *
	 * @var array
	 */
	protected $casts = ['quantity' => 'object'];

	/**
	 * Set model validation rules.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'code' => 'required|max:255|unique:discount_codes,code,' . $this->id,
			'use_limit_id' => 'required|integer',
			'use_limit' => 'required_unless:use_limit_id,' . static::USE_LIMIT_UNLIMITED . '|numeric|min:1',
			'date_limit_id' => 'required|integer',
			'from_date' => 'required_if:date_limit_id,' . static::DATE_LIMIT_LIMITED . '|date',
			'to_date' => 'required_if:date_limit_id,' . static::DATE_LIMIT_LIMITED . '|date|after:from_date',
			'value_type_id' => 'required|integer',
			'value' => 'required|numeric|min:1',
			'min_value' => 'numeric|min:1'
		];
	}

	/**
	 * Set model validation messages.
	 *
	 * @return array
	 */
	public function messages()
	{
		return [
			'required_unless' => 'The :attribute is required.'
		];
	}

	/**
	 * Get the user that belongs to discount.
	 *
	 * @return array
	 */
	public function user()
	{
		return $this->belongsTo('App\Models\User');
	}

	/**
	 * Get the code used that belongs to discount.
	 *
	 * @return array
	 */
	public function discountCodeUsed()
	{
		return $this->hasMany('App\Models\DiscountCodeUsed', 'discount_id');
	}

	/**
	 * Returns the number of times code is used.
	 *
	 * @return int
	 */
	public function getUsedCount()
	{
		return $this->discountCodeUsed
			->count();
	}

	/**
	 * Returns if the discount code has a use limit or not.
	 *
	 * @return boolean
	 */
	public function hasUseLimit()
	{
		return ($this->use_limit_id === static::USE_LIMIT_UNLIMITED) ? false : true;
	}

	/**
	 * Returns if the discount code has a use limit left or not.
	 *
	 * @return boolean
	 */
	public function hasUsedLimitLeft()
	{
		if ($this->hasUseLimit()) {
			return $this->use_limit > $this->getUsedCount();
		}
		return true;
	}

	/**
	 * Returns if the discount code has a date limit or not.
	 *
	 * @return boolean
	 */
	public function hasDateLimit()
	{
		return $this->date_limit_id === static::DATE_LIMIT_LIMITED;
	}

	/**
	 * Returns if the discount code has a date limit left or not.
	 *
	 * @return boolean
	 */
	public function hasDateLimitLeft()
	{
		if ($this->hasDateLimit()) {
			$today = date('Y-m-d H:i:s');
			return $this->from_date <= $today && $today <= $this->to_date;
		}
		return true;
	}

	/**
	 * Returns if the discount code has a amount value type or not.
	 *
	 * @return boolean
	 */
	public function hasAmountValue()
	{
		return $this->value_type_id === static::VALUE_TYPE_AMOUNT;
	}

	/**
	 * Returns if the discount code has a minimum order value or not.
	 *
	 * @return boolean
	 */
	public function hasMinValue()
	{
		return $this->min_value > 0;
	}

	/**
	 * Returns if the discount code has passed minimum order value or not.
	 *
	 * @return boolean
	 */
	public function hasPassedMinValueCheck()
	{
		if ($this->hasMinValue()) {
			return $this->min_value <= getBasketSubtotal();
		}
		return true;
	}

	/**
	 * Returns the discount code use type title.
	 *
	 * @return string
	 */
	public function getUseType()
	{
		$title = null;
		if ($this->use_limit_id === static::USE_LIMIT_SINGLE) {
			$title = 'Single';
		} elseif ($this->use_limit_id === static::USE_LIMIT_MULTIPLE) {
			$title = 'Multiple';
		} elseif ($this->use_limit_id === static::USE_LIMIT_UNLIMITED) {
			$title = 'Unlimited';
		}
		return $title;
	}

	/**
	 * Returns the discount code date limit type title.
	 *
	 * @return string
	 */
	public function getDateLimit()
	{
		$title = null;
		if ($this->date_limit_id === static::DATE_LIMIT_LIMITED) {
			$title = 'Limited';
		} elseif ($this->date_limit_id === static::DATE_LIMIT_UNLIMITED) {
			$title = 'Unlimited';
		}
		return $title;
	}

	/**
	 * Returns the discount code value used by basket.
	 *
	 * @return string
	 */
	public function getBasketValue()
	{
		$value = $this->value;
		if ($this->hasQuantityRules()) {
			$basketQuantity = getBasketItemsQuantity();
			foreach ($this->quantity as $quantityRule) {
				$limits = explode('-', $quantityRule->quantity);
				if (trim($limits[0]) <= $basketQuantity && $basketQuantity <= trim($limits[1])) {
					$value = $quantityRule->value;
				}
			}
		}
		return $value;
	}

	/**
	 * Returns the discount code value with symbol.
	 *
	 * @return string
	 */
	public function getValueWithSymbol()
	{
		$value = null;
		if ($this->hasAmountValue()) {
			$value = $this->getValueSymbol() . formatPrice($this->value);
		} else {
			$value = $this->value . $this->getValueSymbol();
		}
		return $value;
	}

	/**
	 * Returns the discount code value symbol.
	 *
	 * @return string
	 */
	public function getValueSymbol()
	{
		return ($this->hasAmountValue()) ? '£' : '%';
	}

	/**
	 * Check's if discount code has quantity rules or not.
	 *
	 * @return boolean
	 */
	public function hasQuantityRules()
	{
		return is_array($this->quantity);
	}

	/**
	 * Returns if the discount code has passed all the apply rules or not.
	 *
	 * @return boolean
	 */
	public function hasPassedApplyRules()
	{
		return $this->hasUsedLimitLeft() && $this->hasDateLimitLeft() && $this->hasPassedMinValueCheck();
	}

	/**
	 * Returns actual discount amount for basket.
	 *
	 * @return float
	 */
	public function getActualAmount()
	{
		$amount = 0;
		if ($this->hasPassedMinValueCheck()) {
			$basketAmount  = setNumberDecimals(Basket::getBasketActualSubtotal() + Basket::getBasketActualVat() + getShippingActualPrice(true));
			$discountValue = $this->hasAmountValue() ? $this->getBasketValue() : ($basketAmount / 100) * $this->getBasketValue();
			$amount        = $discountValue > $basketAmount ? $basketAmount : $discountValue;
		}
		return setNumberDecimals($amount);
	}

	/**
	 * Returns discount amount for basket.
	 *
	 * @param boolean $actual
	 *
	 * @return float
	 */
	public function getAmount($actual = false)
	{
		$amount = $this->getActualAmount();
		if ($actual === false && $this->hasPassedMinValueCheck()) {
			$basketAmount  = Basket::getBasketTotal();
			$discountValue = $this->hasAmountValue() ? convertPriceToCurrentCurrency($this->getBasketValue()) : ($basketAmount / 100) * $this->getBasketValue();
			$amount        = $discountValue > $basketAmount ? $basketAmount : $discountValue;
		}
		return setNumberDecimals($amount);
	}

	/**
	 * Finds the discount code entity by code.
	 *
	 * @param string $code
	 *
	 * @return array
	 */
	public static function findByCode($code)
	{
		return static::where('code', $code)
			->first();
	}

	/**
	 * Function to perform default actions on events.
	 */
	protected static function boot()
	{
		parent::boot();
		static::creating(function ($model) {
			$model->user_id   = getAuthenticatedUser()->id;
			$model->use_limit = ($model->use_limit_id == 1) ? 1 : $model->use_limit;
			$model->from_date = ($model->from_date) ? formatDate($model->from_date, 'Y-m-d') : null;
			$model->to_date   = ($model->to_date) ? formatDate($model->to_date, 'Y-m-d') : null;
		});
		static::updating(function ($model) {
			$model->from_date = ($model->from_date) ? formatDate($model->from_date, 'Y-m-d') : null;
			$model->to_date   = ($model->to_date) ? formatDate($model->to_date, 'Y-m-d') : null;
		});
	}

	/**
	 * Returns the csv file destination path.
	 *
	 * @return string
	 */
	public static function getCSVFilePath()
	{
		return self::CSV_DESTINATION_PATH . '/bulk-discount-codes_' . date('dmY') . '.csv';
	}
}
