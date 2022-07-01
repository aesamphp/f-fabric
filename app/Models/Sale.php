<?php

namespace App\Models;

use Carbon\Carbon;

class Sale extends AppModel
{

    const TYPE_SALE = 1;
    const TYPE_PROMO = 2;
    const CSV_DESTINATION_PATH = 'downloads/commissions';

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'sales';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'order_item_id', 'type_id', 'amount', 'tax'];

    /**
     * The csv head attributes of the model.
     *
     * @var array
     */
    protected $csvHeader = ['Commission ID', 'Designer ID', 'Designer Name', 'Order ID', 'Design ID', 'Design Title', 'Amount', 'Payment Method', 'Paypal Email Address', 'VAT Number', 'Address', 'Type', 'Status', 'Created'];

    /**
     * Set model validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_id' => 'required|integer',
            'order_item_id' => 'required|integer',
            'type_id' => 'required|integer',
            'amount' => 'required|numeric',
            'tax' => 'numeric'
        ];
    }

    /**
     * Set model create by administrator validation rules.
     *
     * @return array
     */
    public function createByAdminRules()
    {
        return [
            'user_friendly_id' => 'required|validateSaleUser',
            'order_friendly_id' => 'required|validateSaleOrder',
            'design_friendly_id' => 'required|validateSaleDesign|validateSaleDesigner',
            'type_id' => 'required|integer',
            'amount' => 'required|numeric'
        ];
    }

    /**
     * Returns the csv item array.
     *
     * @return array
     */
    public function buildCSVArray()
    {
        return [
            'id' => $this->id,
            'user_friendly_id' => $this->user->friendly_id,
            'user_full_name' => $this->user->getFullName(),
            'order_friendly_id' => $this->orderItem->order->friendly_id,
            'design_friendly_id' => $this->getDesignID(),
            'design_title' => $this->getDesignTitle(),
            'amount' => formatPrice($this->amount),
            'payment_method' => $this->getPaymentMethodTitle(),
            'paypal_email' => $this->getUserPaypalEmailAddress(),
            'vat_number' => $this->getUserVatNumber(),
            'address' => $this->getUserAddress(),
            'type' => $this->getType(),
            'status' => $this->getStatus(),
            'created_at' => formatDate($this->created_at)
        ];
    }

    /**
     * Get the user that belongs to sale.
     *
     * @return array
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * Get the order item that belongs to sale.
     *
     * @return array
     */
    public function orderItem()
    {
        return $this->belongsTo('App\Models\OrderItem');
    }

    /**
     * Returns is sale commission is paid or not.
     *
     * @return boolean
     */
    public function isPaid()
    {
        return $this->paid === 1;
    }

    /**
     * Returns the sale commission status.
     *
     * @return string
     */
    public function getStatus()
    {
        return ($this->isPaid()) ? 'Approved' : 'Pending';
    }

    /**
     * Returns the calculated tax amount.
     *
     * @return float
     */
    public function calculateTaxAmount()
    {
        $taxAmount = 0;
        if ($this->applyTaxDeduction()) {
            $taxAmount = calculateVAT($this->amount);
        }
        return formatPrice($taxAmount);
    }

    /**
     * Returns if tax deduction is applicable or not.
     *
     * @return boolean
     */
    public function applyTaxDeduction()
    {
        $user = $this->user;
        return ($user->isVATRegistered() && PaymentDetail::isEUCountry($user->paymentDetail->country)) ? false : true;
    }

    /**
     * Returns the total commission amount after tax deduction.
     *
     * @return float
     */
    public function getTotalAmount()
    {
        return formatPrice($this->amount - $this->tax);
    }


    /**
     * Returns the total commission for that month so far
     *
     * @return float
     */
    public function getTotalAmountOfCommissionsForMonth($user)
    {
        return formatPrice($this->where('created_at', '>', new Carbon('first day of this month'))
            ->where('user_id', $user->id)
            ->sum('amount'));
    }

    /**
     * Returns the total commission for last month
     *
     * @return float
     */
    public function getTotalAmountOfCommissionsForLastMonth($user)
    {
        return formatPrice($this->whereBetween('created_at', [new Carbon('first day of last month'), new Carbon('last day of last month')])
            ->where('user_id', $user->id)
            ->sum('amount'));
    }

    /**
     * Returns the total commissions
     *
     * @return float
     */
    public function getTotalAmountOfCommissions($user)
    {
        return formatPrice($this->where('user_id', $user->id)->sum('amount'));
    }


    /**
     * Returns the sale commission status class.
     *
     * @return string
     */
    public function getStatusClass()
    {
        return str_slug($this->getStatus());
    }

    /**
     * Returns the sale commission type title.
     *
     * @return string
     */
    public function getType()
    {
        $title   = null;
        $options = static::getTypeOptions();
        foreach ($options as $option) {
            if ($option['id'] === $this->type_id) {
                $title = $option['title'];
            }
        }
        return $title;
    }

    /**
     * Returns the sale commission design ID.
     *
     * @return string
     */
    public function getDesignID()
    {
        $orderItem = $this->orderItem;
        return $orderItem->isDesign() ? $orderItem->design->friendly_id : 'N/A';
    }

    /**
     * Returns the sale commission design title.
     *
     * @return string
     */
    public function getDesignTitle()
    {
        $orderItem = $this->orderItem;
        return $orderItem->isDesign() ? $orderItem->getTitle() : 'N/A';
    }

    /**
     * Returns the sale commission payment method title.
     *
     * @return string
     */
    public function getPaymentMethodTitle()
    {
        $title = 'N/A';
        $user  = $this->user;
        if ($user->hasPaymentDetails()) {
            $title = $user->hasBucksnetPaymentDetails() ? 'Bucksnet' : 'Paypal';
        }
        return $title;
    }

    /**
     * Returns the sale commission user PayPal email address.
     *
     * @return string
     */
    public function getUserPaypalEmailAddress()
    {
        $email = 'N/A';
        $user  = $this->user;
        if ($user->hasPaymentDetails()) {
            $email = $user->paymentDetail->paypal_email;
        }
        return $email;
    }

    /**
     * Returns the sale commission user vat number.
     *
     * @return string
     */
    public function getUserVatNumber()
    {
        $vatNumber = 'N/A';
        $user      = $this->user;
        if ($user->hasPaymentDetails()) {
            $vatNumber = $user->isVATRegistered() ? $user->getVATNumber() : $vatNumber;
        }
        return $vatNumber;
    }

    /**
     * Returns the sale commission user address.
     *
     * @return string
     */
    public function getUserAddress()
    {
        $address = 'N/A';
        $user    = $this->user;
        if ($user->hasDefaultAddress()) {
            $userAddress = $user->getDefaultAddress();
            $address     = formatAddress($userAddress, ['address_line1', 'address_line2', 'city', 'postcode', 'state', 'getCountryName'], false);
        }
        return $address;
    }

    /**
     * Returns the csv file destination path.
     *
     * @return string
     */
    public function getCSVFilePath()
    {
        return static::CSV_DESTINATION_PATH . '/commissions_' . date('dmY') . '.csv';
    }

    /**
     * Returns the sale commission type options.
     *
     * @return array
     */
    public static function getTypeOptions()
    {
        return [
            ['id' => static::TYPE_SALE, 'title' => 'Sale'],
            ['id' => static::TYPE_PROMO, 'title' => 'Promo']
        ];
    }

}
