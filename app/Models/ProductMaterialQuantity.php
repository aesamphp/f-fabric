<?php

namespace App\Models;

class ProductMaterialQuantity extends AppModel
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'product_material_quantities';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['product_material_id', 'product_quantity_id', 'price'];

    /**
     * Set model validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'product_material_id' => 'required|integer',
            'product_quantity_id' => 'required|integer',
            'price' => 'required|numeric'
        ];
    }

    /**
     * Get the material that belongs to quantity.
     *
     * @return array
     */
    public function material()
    {
        return $this->belongsTo('App\Models\ProductMaterial', 'product_material_id');
    }

    /**
     * Get the quantity that belongs to material.
     *
     * @return array
     */
    public function quantity()
    {
        return $this->belongsTo('App\Models\ProductQuantity', 'product_quantity_id');
    }

    /**
     * Apply quantity rules price on product material price.
     *
     * @param float $price
     * @param int $quantity
     *
     * @return float
     */
    public function applyQuantityRulePrice($price, $quantity)
    {
        $quantityRule = $this->quantity;
        if (is_null($quantityRule->upper_limit) && $quantity >= $quantityRule->lower_limit) {
            $price = $this->price;
        } elseif ($quantityRule->lower_limit && $quantityRule->upper_limit && $quantity >= $quantityRule->lower_limit && $quantity <= $quantityRule->upper_limit) {
            $price = $this->price;
        } elseif (is_null($quantityRule->lower_limit) && $quantity >= $quantityRule->upper_limit) {
            $price = $this->price;
        }
        return $price;
    }

}
