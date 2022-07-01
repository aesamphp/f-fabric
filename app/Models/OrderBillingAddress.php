<?php

namespace App\Models;

class OrderBillingAddress extends AppModel {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'order_billing_addresses';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['order_id', 'title', 'first_name', 'last_name', 'address_line1', 'address_line2', 'city', 'postcode', 'state', 'phone', 'country'];
    
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
            'title' => 'required|max:255',
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'address_line1' => 'required|max:255',
            'address_line2' => 'max:255',
            'city' => 'required|max:255',
            'postcode' => 'required|max:255',
            'state' => 'required_if:country,US|max:255',
            'phone' => 'numeric',
            'country' => 'required|max:255'
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

}
