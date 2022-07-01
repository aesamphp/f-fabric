<?php

namespace App\Models;

class Category extends AppModel {
    
    const FABRIC = 1;
    const WALLPAPER = 2;
    const GIFT_WRAP = 3;
    const ACCESSORIES = 4;
    const ATLAS = 5;
    const SAMPLES = 6;
    const PLAIN_FABRIC = 7;
    const IMAGE_DESTINATION_PATH = 'uploads/images/category';

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'categories';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'excerpt', 'description', 'image_path', 'meta_description', 'meta_keywords', 'manipulate'];
    
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
            'title' => 'required|max:250',
            'manipulate' => 'required|boolean'
        ];
    }
    
    /**
     * Get the products that belongs to category.
     * 
     * @return array
     */
    public function products() {
        return $this->hasMany('App\Models\Product');
    }
    
    /**
     * Get the design types that belongs to category.
     * 
     * @return array
     */
    public function designTypes() {
        return $this->hasMany('App\Models\CategoryDesignType');
    }
    
    /**
     * Get the cms products that belongs to category.
     * 
     * @return array
     */
    public function cmsProducts() {
        return $this->hasMany('App\Models\CMSProduct');
    }
    
    /**
     * Get the active products that belongs to category.
     * 
     * @return array
     */
    public function getActiveProducts() {
        return $this->products
                ->where('disabled', 0);
    }
    
    /**
     * Returns shoppable categories.
     * 
     * @return array
     */
    public static function getShoppableCategories() {
        return static::where('manipulate', 1)
                ->where('disabled', 0)
                ->get();
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
