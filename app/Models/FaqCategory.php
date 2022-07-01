<?php

namespace App\Models;

class FaqCategory extends AppModel {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'faq_categories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'meta_description', 'meta_keywords'];
    
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
            'title' => 'required|max:250'
        ];
    }
    
    /**
     * Get the faqs that belongs to category.
     * 
     * @return array
     */
    public function faqs() {
        return $this->hasMany('App\Models\Faq', 'category_id');
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
