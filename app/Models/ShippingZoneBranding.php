<?php

namespace App\Models;

class ShippingZoneBranding extends AppModel {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'shipping_zone_brandings';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['zone_id', 'weight_branding_id', 'price'];

    /**
     * Set model validation rules.
     * 
     * @return array
     */
    public function rules() {
        return [
            'zone_id' => 'required|integer',
            'weight_branding_id' => 'required|integer',
            'price' => 'required|numeric|min:0'
        ];
    }

    /**
     * Get the branding that belongs to zone.
     * 
     * @return array
     */
    public function branding() {
        return $this->belongsTo('App\Models\ShippingWeightBranding', 'weight_branding_id');
    }

    /**
     * Get the zone that belongs to branding.
     * 
     * @return array
     */
    public function zone() {
        return $this->belongsTo('App\Models\ShippingZone');
    }
    
    /**
     * Returns the branding actual shipping price.
     * 
     * @param string $country
     * 
     * @return float
     */
    public function getShippingActualPrice($country) {
        return applyShippingDiscount($this->price, $country);
    }
    
    /**
     * Returns the branding shipping price.
     * 
     * @param string $country
     * @param boolean $netPrice
     * @param boolean $actual
     * 
     * @return float
     */
    public function getShippingPrice($country, $netPrice = false, $actual = false) {
        $actualPrice = $this->getShippingActualPrice($country);
        $price = ($actual === true) ? $actualPrice : convertPriceToCurrentCurrency($actualPrice);
        $vat = ($price > 0) ? calculateVAT($price) : 0;
        return ($netPrice === true) ? $price - $vat : $price;
    }

}
