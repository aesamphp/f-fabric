<?php

namespace App\Models;

class CategoryDesignType extends AppModel {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'category_design_types';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['category_id', 'design_type_id'];

    /**
     * Set model validation rules.
     * 
     * @return array
     */
    public function rules() {
        return [
            'category_id' => 'required|integer',
            'design_type_id' => 'required|integer'
        ];
    }

    /**
     * Get the category that belongs to design type.
     * 
     * @return array
     */
    public function category() {
        return $this->belongsTo('App\Models\Category');
    }

    /**
     * Get the design type that belongs to category.
     * 
     * @return array
     */
    public function designType() {
        return $this->belongsTo('App\Models\DesignType');
    }

}
