<?php

namespace App\Models;

class DesignCategory extends AppModel {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'design_categories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['design_id', 'category_id'];

    /**
     * Set model validation rules.
     * 
     * @return array
     */
    public function rules() {
        return [
            'design_id' => 'required|integer',
            'category_id' => 'required|integer'
        ];
    }
    
    /**
     * Get the category that belongs to design.
     * 
     * @return array
     */
    public function category() {
        return $this->belongsTo('App\Models\Category');
    }

}
