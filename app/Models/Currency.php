<?php

namespace App\Models;

class Currency extends AppModel {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'currencies';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'code', 'symbol', 'exchange_rate', 'default'];

    /**
     * The attributes that are nullable by default.
     *
     * @var array
     */
    protected $nullable = ['exchange_rate'];

    /**
     * Set model validation rules.
     * 
     * @return array
     */
    public function rules() {
        return [
            'title' => 'required|max:255',
            'code' => 'required|max:255|unique:countries,code,' . $this->id,
            'symbol' => 'required|max:255',
            'exchange_rate' => 'required_if:default,0|numeric|min:0',
            'default' => 'boolean'
        ];
    }
    
    /**
     * Returns if currency is default or not.
     * 
     * @return boolean
     */
    public function isDefault() {
        return $this->default === 1;
    }
    
    /**
     * Returns the default currency.
     * 
     * @return array
     */
    public static function getDefaultCurrency() {
        return static::where('default', 1)
                ->firstOrFail();
    }

}
