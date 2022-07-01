<?php

namespace App\Models;

class ProductQuantity extends AppModel {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'product_quantities';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['product_id', 'lower_limit', 'upper_limit'];
    
    /**
     * The attributes that are nullable by default.
     *
     * @var array
     */
    protected $nullable = ['lower_limit', 'upper_limit'];
    
    /**
     * Set model validation rules.
     * 
     * @return array
     */
    public function rules() {
        return [
            'product_id' => 'required|integer',
            'lower_limit' => 'required_without:upper_limit|integer',
            'upper_limit' => 'required_without:lower_limit|integer'
        ];
    }
    
    /**
     * Return's quantity rule title.
     * 
     * @return string
     */
    public function getTitle() {
        $title = arrayToString([$this->lower_limit, $this->upper_limit], ' - ');
        if (is_null($this->lower_limit)) {
            $title = $this->upper_limit . '+';
        } elseif (is_null($this->upper_limit)) {
            $title = $this->lower_limit;
        }
        return $title;
    }

}
