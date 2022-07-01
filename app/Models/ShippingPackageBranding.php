<?php

namespace App\Models;

class ShippingPackageBranding extends AppModel {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'shipping_package_brandings';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['package_type_id', 'weight_branding_id', 'price'];

    /**
     * Set model validation rules.
     * 
     * @return array
     */
    public function rules() {
        return [
            'package_type_id' => 'required|integer',
            'weight_branding_id' => 'required|integer',
            'price' => 'required|numeric'
        ];
    }
    
    /**
     * Get the branding that belongs to package.
     * 
     * @return array
     */
    public function branding() {
        return $this->belongsTo('App\Models\ShippingWeightBranding', 'weight_branding_id');
    }
    
    /**
     * Get the package that belongs to branding.
     * 
     * @return array
     */
    public function package() {
        return $this->belongsTo('App\Models\ShippingPackageType', 'package_type_id');
    }

}
