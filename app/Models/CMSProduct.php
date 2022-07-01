<?php

namespace App\Models;

class CMSProduct extends AppModel {
    
    const IMAGE_DESTINATION_PATH = 'uploads/images/cms-product';

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'cms_products';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['category_id', 'title', 'content', 'image1_path', 'image2_path', 'image3_path'];

    /**
     * Set model validation rules.
     * 
     * @return array
     */
    public function rules() {
        return [
            'category_id' => 'required|integer',
            'title' => 'required|max:255',
            'content' => 'required',
            'image1_path' => 'required',
            'image2_path' => 'required',
            'image3_path' => 'required'
        ];
    }

    /**
     * Get the category that belongs to product.
     * 
     * @return array
     */
    public function category() {
        return $this->belongsTo('App\Models\Category');
    }

}
