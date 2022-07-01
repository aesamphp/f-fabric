<?php

namespace App\Models;

class PaymentGatewayOption extends AppModel {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'payment_gateway_options';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['gateway_id', 'path', 'value'];
    
    /**
     * The attributes that are nullable by default.
     *
     * @var array
     */
    protected $nullable = ['value'];

    /**
     * Set model validation rules.
     * 
     * @return array
     */
    public function rules() {
        return [
            'gateway_id' => 'required|integer',
            'path' => 'required|max:255|unique:payment_gateway_options,path,' . $this->id
        ];
    }
    
    /**
     * Get the field that belongs to option.
     * 
     * @return array
     */
    public function field() {
        return $this->hasOne('App\Models\PaymentGatewayOptionField', 'option_id');
    }

}
