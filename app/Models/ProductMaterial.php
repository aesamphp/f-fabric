<?php

namespace App\Models;

class ProductMaterial extends AppModel
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'product_materials';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['product_id', 'material_id', 'price'];

    /**
     * The attributes that are nullable by default.
     *
     * @var array
     */
    protected $nullable = ['material_id'];

    /**
     * Set model validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'product_id' => 'required|integer',
            'material_id' => 'integer',
            'price' => 'required|numeric'
        ];
    }

    /**
     * Get the product that belongs to material.
     *
     * @return array
     */
    public function product()
    {
        return $this->belongsTo('App\Models\Product');
    }

    /**
     * Get the material that belongs to product.
     *
     * @return array
     */
    public function material()
    {
        return $this->belongsTo('App\Models\Material');
    }

    /**
     * Get the quantity rules that belongs to material.
     *
     * @return array
     */
    public function quantities()
    {
        return $this->hasMany('App\Models\ProductMaterialQuantity');
    }

    /**
     * Checks if product material has discount rules or not.
     *
     * @return boolean
     */
    public function hasQuantityRules()
    {
        return $this->quantities()->count() > 0;
    }

    /**
     * Returns product material price.
     *
     * @param boolean $apply
     *
     * @return float
     */
    public function getPrice($apply = false)
    {
        return applyShopPrice($this->price, $apply);
    }

    /**
     * Returns quantity of product from basket.
     *
     * @return float
     */
    public function getQuantityOfProductFromBasket()
    {
        $basket = session()->get('basket');

        if (!$basket) {
            return false;
        }

        $quantities = [];

        foreach ($basket as $key => $item) {
            if (array_key_exists($item->material_id, $quantities)) {
                $quantities[$item->material_id] = $quantities[$item->material_id] + $item->quantity;
                continue;
            }

            $quantities[$item->material_id] = $item->quantity;
        }

        return array_key_exists($this->material_id, $quantities) ? $quantities[$this->material_id] : false;
    }

    /**
     * Returns product material price after applying quantity discount rule price to it.
     *
     * @param bool $apply
     * @param int $quantity
     * @return float
     */
    public function getPriceWithQuantityRules($apply = false, $quantity = 1)
    {
        $quantity = $this->getQuantityOfProductFromBasket() + $quantity;
        $price    = $this->price;

        if ($this->hasQuantityRules()) {
            foreach ($this->quantities as $quantityRule) {
                $price = $quantityRule->applyQuantityRulePrice($price, $quantity);
            }
        }

        return applyShopPrice($price, $apply);
    }

}