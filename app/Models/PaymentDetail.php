<?php

namespace App\Models;

class PaymentDetail extends AppModel {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'payment_details';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['bank_name', 'bucksnet_id', 'paypal_email', 'vat_number', 'country', 'vat_registered'];

    /**
     * The attributes that are nullable by default.
     *
     * @var array
     */
    protected $nullable = ['bank_name', 'bucksnet_id', 'paypal_email', 'vat_number'];

    /**
     * Set model validation rules.
     * 
     * @return array
     */
    public function rules() {
        return [
            'bank_name' => 'max:255',
            'bucksnet_id' => 'max:255|unique:payment_details,bucksnet_id,' . $this->id,
            'paypal_email' => 'required_unless:country,GB|email|max:255',
            'vat_number' => 'required_if:vat_registered,1|max:255|validateVatNumber',
            'country' => 'required|max:255',
            'vat_registered' => 'required|boolean'
        ];
    }
    
    /**
     * Set model validation rules.
     * 
     * @return array
     */
    public function bucksnetRules() {
        return [
            'bank_name' => 'required|max:255',
            'account_holder_name' => 'required|max:255',
            'account_number' => 'required|numeric|digits_between:8,8',
            'sort_code' => 'required|numeric|digits_between:6,6|validateBankDetails'
        ];
    }
    
    /**
     * Set model validation messages.
     * 
     * @return array
     */
    public function messages() {
        return [
            'account_number.digits_between' => 'The :attribute must be 8 digits.',
            'sort_code.digits_between' => 'The :attribute must be 6 digits.',
            'paypal_email.required_unless' => 'The :attribute field is required.'
        ];
    }
    
    /**
     * Get the user that belongs to payment details.
     * 
     * @return array
     */
    public function user() {
        return $this->belongsTo('App\Models\User');
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
     * Returns the EU VIES country code.
     * 
     * @param string $code
     * 
     * @return string
     */
    public static function getEUVIESCountryCode($code) {
        $viesCode = null;
        $codes = static::getEUVIESCountryCodes();
        foreach ($codes as $key => $value) {
            if ($code === $key) {
                $viesCode = $value;
            }
        }
        return $viesCode;
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
     * Returns the EU VIES country codes.
     * 
     * @return array
     */
    public static function getEUVIESCountryCodes() {
        return [
            'AT' => 'AT',
            'BE' => 'BE',
            'BG' => 'BG',
            'HR' => 'HR',
            'CY' => 'CY',
            'CZ' => 'CZ',
            'DK' => 'DK',
            'EE' => 'EE',
            'FI' => 'FI',
            'FR' => 'FR',
            'DE' => 'DE',
            'GR' => 'EL',
            'HU' => 'HU',
            'IE' => 'IE',
            'IT' => 'IT',
            'LV' => 'LV',
            'LT' => 'LT',
            'LU' => 'LU',
            'MT' => 'MT',
            'NL' => 'NL',
            'PL' => 'PL',
            'PT' => 'PT',
            'RO' => 'RO',
            'SK' => 'SK',
            'SI' => 'SI',
            'ES' => 'ES',
            'SE' => 'SE',
            'GB' => 'GB'
        ];
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
