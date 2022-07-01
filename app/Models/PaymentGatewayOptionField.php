<?php

namespace App\Models;

class PaymentGatewayOptionField extends AppModel {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'payment_gateway_option_fields';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['option_id', 'type_id', 'label', 'class', 'options'];
    
    /**
     * The attributes that are nullable by default.
     *
     * @var array
     */
    protected $nullable = ['class', 'options'];

    /**
     * Set model validation rules.
     * 
     * @return array
     */
    public function rules() {
        return [
            'option_id' => 'required|integer',
            'type_id' => 'required|integer',
            'label' => 'required|max:255',
            'class' => 'max:255'
        ];
    }

}
