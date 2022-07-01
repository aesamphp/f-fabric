<?php

namespace App\Models;

class ShippingZone extends AppModel {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'shipping_zones';

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
     * Get the countries that belongs to zone.
     * 
     * @return array
     */
    public function countries() {
        return $this->hasMany('App\Models\Country', 'zone_id');
    }
    
    /**
     * Get the countries that belongs to zone.
     * 
     * @return array
     */
    public function brandings() {
        return $this->hasMany('App\Models\ShippingZoneBranding', 'zone_id');
    }

}
