<?php

namespace App\Models;

class DesignTip extends AppModel {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'design_tips';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['category_id', 'title', 'content', 'meta_description', 'meta_keywords'];
    
    /**
     * The attributes that are nullable by default.
     *
     * @var array
     */
    protected $nullable = ['meta_description', 'meta_keywords'];

    /**
     * Set model validation rules.
     * 
     * @return array
     */
    public function rules() {
        return [
            'category_id' => 'required|integer',
            'title' => 'required|max:250',
            'content' => 'required'
        ];
    }

    /**
     * Get the category that belongs to design tip.
     * 
     * @return array
     */
    public function category() {
        return $this->belongsTo('App\Models\DesignTipCategory');
    }
    
    /**
     * Function to perform default actions on events.
     */
    protected static function boot() {
        parent::boot();
        static::creating(function($model) {
            $model->setIdentifier($model->title);
        });
        static::updating(function($model) {
            $model->setIdentifier($model->title);
        });
    }

}
