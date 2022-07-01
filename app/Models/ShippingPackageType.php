<?php

namespace App\Models;

class ShippingPackageType extends AppModel {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'shipping_package_types';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title'];

    /**
     * Set model validation rules.
     * 
     * @return array
     */
    public function rules() {
        return [
            'title' => 'required|max:255'
        ];
    }
    
    /**
     * Get the products that belongs to package type.
     * 
     * @return array
     */
    public function products() {
        return $this->hasMany('App\Models\ProductPackageType');
    }
    
    /**
     * Get the branding that belongs to package.
     * 
     * @return array
     */
    public function packageBranding() {
        return $this->hasOne('App\Models\ShippingPackageBranding', 'package_type_id');
    }

}
