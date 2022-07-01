<?php

namespace App\Models;

class PaymentGateway extends AppModel {
    
    const SAGEPAY = 1;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'payment_gateways';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'active'];

    /**
     * Set model validation rules.
     * 
     * @return array
     */
    public function rules() {
        return [
            'title' => 'required|max:255',
            'active' => 'required|boolean'
        ];
    }
    
    /**
     * Get the options that belongs to payment gateway.
     * 
     * @return array
     */
    public function options() {
        return $this->hasMany('App\Models\PaymentGatewayOption', 'gateway_id');
    }

}
