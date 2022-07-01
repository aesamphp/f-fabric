<?php

namespace App\Models;

class DesignTipCategory extends AppModel {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'design_tip_categories';

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
     * Get the design tips that belongs to category.
     * 
     * @return array
     */
    public function designTips() {
        return $this->hasMany('App\Models\DesignTip', 'category_id');
    }
    
    /**
     * Return the search design tips with category.
     * 
     * @param string $keyword
     * 
     * @return array
     */
    public function searchDesignTips($keyword) {
        return $this->whereHas('designTips', function ($query) use ($keyword) {
                    $query->where('title', 'like', $keyword)
                            ->orWhere('content', 'like', $keyword);
                })
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
