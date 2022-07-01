<?php

namespace App\Models;

class OrderShippingAddress extends AppModel {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'order_shipping_addresses';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['order_id', 'weight_branding_id', 'title', 'first_name', 'last_name', 'address_line1', 'address_line2', 'city', 'postcode', 'state', 'phone', 'country', 'price'];
    
    /**
     * The attributes that are nullable by default.
     *
     * @var array
     */
    protected $nullable = ['address_line2', 'state', 'phone'];

    /**
     * Set model validation rules.
     * 
     * @return array
     */
    public function rules() {
        return [
            'order_id' => 'required|integer',
            'weight_branding_id' => 'required|integer',
            'title' => 'required|max:255',
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'address_line1' => 'required|max:255',
            'address_line2' => 'max:255',
            'city' => 'required|max:255',
            'postcode' => 'required|max:255',
            'state' => 'required_if:country,US|max:255',
            'phone' => 'numeric',
            'country' => 'required|max:255',
            'price' => 'required|numeric'
        ];
    }
    
    /**
     * Get the order that belongs to address.
     * 
     * @return array
     */
    public function order() {
        return $this->belongsTo('App\Models\Order');
    }
    
    /**
     * Get the country that belongs to address.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function getCountry() {
        return $this->belongsTo('App\Models\Country', 'country', 'code');
    }
    
    /**
     * Get the branding that belongs to address.
     * 
     * @return array
     */
    public function branding() {
        return $this->belongsTo('App\Models\ShippingWeightBranding', 'weight_branding_id');
    }
    
    /**
     * Returns the user's full name.
     * 
     * @return string
     */
    public function getFullName() {
        return formatName([$this->title, $this->first_name, $this->last_name]);
    }
    
    /**
     * Returns country name.
     * 
     * @return string
     */
    public function getCountryName() {
        return $this->getCountry->title;
    }
    
    /**
     * Returns the order shipping address xml elements array.
     * 
     * @return array
     */
    public function buildOrderShippingAddressXMLElementsArray() {
        return [
            'name' => $this->getFullName(),
            'phone' => $this->phone,
            'branding' => $this->branding->title,
            'address' => [
                'line1' => $this->address_line1,
                'line2' => $this->address_line2,
                'city' => $this->city,
                'postcode' => $this->postcode,
                'state' => $this->state,
                'country' => $this->getCountryName()
            ]
        ];
    }

}
