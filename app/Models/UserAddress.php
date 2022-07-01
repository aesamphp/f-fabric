<?php

namespace App\Models;

class UserAddress extends AppModel {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'user_addresses';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'address_line1', 'address_line2', 'city', 'postcode', 'state', 'country'];

    /**
     * The attributes that are nullable by default.
     *
     * @var array
     */
    protected $nullable = ['address_line2', 'state'];
    
    /**
     * The attributes that should converted into string.
     *
     * @var array
     */
    protected $toString = ['title', 'address_line1', 'address_line2', 'city', 'postcode', 'state', 'country'];
    
    /**
     * The attributes of an address.
     *
     * @var array 
     */
    public $addressAttributes = ['title', 'address_line1', 'address_line2', 'city', 'postcode', 'state', 'getCountryName'];

    /**
     * Set model validation rules.
     * 
     * @return array
     */
    public function rules() {
        return [
            'title' => 'required|max:255',
            'address_line1' => 'required|max:255',
            'address_line2' => 'max:255',
            'city' => 'required|max:255',
            'postcode' => 'required|max:255',
            'state' => 'required_if:country,US|max:255',
            'country' => 'required|max:255'
        ];
    }
    
    /**
     * Get the user that belongs to address.
     * 
     * @return array
     */
    public function user() {
        return $this->belongsTo('App\Models\User');
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
     * Returns country name.
     * 
     * @return string
     */
    public function getCountryName() {
        return $this->getCountry->title;
    }
    
    /**
     * Function to perform default actions on events.
     */
    protected static function boot() {
        parent::boot();
        static::creating(function($model) {
            $model->user_id = getAuthenticatedUser()->id;
        });
    }

}
