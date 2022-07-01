<?php

namespace App\Models;

class DiscountCodeUsed extends AppModel {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'discount_code_used';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['discount_id', 'order_id', 'amount'];

    /**
     * Set model validation rules.
     * 
     * @return array
     */
    public function rules() {
        return [
            'discount_id' => 'required|integer',
            'order_id' => 'required|integer',
            'amount' => 'required|numeric'
        ];
    }
    
    /**
     * Get the discount code that belongs to code used.
     * 
     * @return array
     */
    public function discountCode() {
        return $this->belongsTo('App\Models\DiscountCode', 'discount_id');
    }
    
    /**
     * Get the order that belongs to code used.
     * 
     * @return array
     */
    public function order() {
        return $this->belongsTo('App\Models\Order');
    }
    
    /**
     * Returns the discount code text.
     * 
     * @return string
     */
    public function getDiscountCode() {
        return ($this->discountCode) ? $this->discountCode->code : 'N/A';
    }

}
