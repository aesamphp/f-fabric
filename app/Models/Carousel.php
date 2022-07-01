<?php

namespace App\Models;

class Carousel extends AppModel {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'carousels';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title'];

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
     * Get the slides that belongs to carousel.
     * 
     * @return array
     */
    public function slides() {
        return $this->hasMany('App\Models\CarouselSlide');
    }

}
