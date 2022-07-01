<?php

namespace App\Models;

class ProductPackageType extends AppModel {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'product_package_types';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['product_id', 'package_type_id'];

    /**
     * Set model validation rules.
     * 
     * @return array
     */
    public function rules() {
        return [
            'product_id' => 'required|integer',
            'package_type_id' => 'required|integer'
        ];
    }
    
    /**
     * Get the product that belongs to package type.
     * 
     * @return array
     */
    public function product() {
        return $this->belongsTo('App\Models\Product');
    }
    
    /**
     * Get the package type that belongs to product.
     * 
     * @return array
     */
    public function packageType() {
        return $this->belongsTo('App\Models\ShippingPackageType');
    }

}
