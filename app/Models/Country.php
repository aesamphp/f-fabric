<?php

namespace App\Models;

use App\Models\Basket;

class Country extends AppModel {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'countries';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['zone_id', 'title', 'code'];
    
    /**
     * The attributes that are nullable by default.
     *
     * @var array
     */
    protected $nullable = ['zone_id'];

    /**
     * Set model validation rules.
     * 
     * @return array
     */
    public function rules() {
        return [
            'zone_id' => 'integer',
            'title' => 'required|max:255',
            'code' => 'required|max:255|unique:countries,code,' . $this->id
        ];
    }
    
    /**
     * Get the zone that belongs to country.
     * 
     * @return array
     */
    public function zone() {
        return $this->belongsTo('App\Models\ShippingZone');
    }
    
    /**
     * Return the list of shipping countries.
     * 
     * @return array
     */
    public static function getShippingCountries() {
        return static::whereNotNull('zone_id')->get();
    }
    
    /**
     * Returns the delivery options available for the country.
     * 
     * @return array
     */
    public function getDeliveryOptions() {
        $deliveryOptions = [];
        foreach ($this->zone->brandings as $branding) {
            if (Basket::getBasketWeight() <= $branding->branding->max_weight) {
                $deliveryOptions[] = $branding;
            }
        }
        return $deliveryOptions;
    }
    
    /**
     * Returns if the country is in EU or not.
     * 
     * @param string $code
     * 
     * @return boolean
     */
    public static function isEUCountry($code) {
        return in_array($code, static::getEUCountryCodes());
    }
    
    /**
     * Returns the EU country codes.
     * 
     * @return array
     */
    public static function getEUCountryCodes() {
        return ["AT", "BE", "BG", "HR", "CY", "CZ", "DK", "EE", "FI", "FR", "DE", "GR", "HU", "IE", "IT", "LV", "LT", "LU", "MT", "NL", "PL", "PT", "RO", "SK", "SI", "ES", "SE", "GB"];
    }
    
    /**
     * Returns an array of countries with US / UK at the top.
     * 
     * @return array
     */
    public static function getCountriesListRearranged() {
        $array = [];
        $countries = static::all();
        foreach ($countries as $country) {
            $array[$country->code] = $country->title;
        }
        $array = ['DE' => $array['DE']] + $array;
        $array = ['FR' => $array['FR']] + $array;
        $array = ['US' => $array['US']] + $array;
        $array = ['GB' => $array['GB']] + $array;
        return $array;
    }
    
}
