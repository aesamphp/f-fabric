<?php

namespace App\Models;

class CarouselSlide extends AppModel {
    
    const CTA_TYPE_INTERNAL = 1;
    const CTA_TYPE_EXTERNAL = 2;
    
    const IMAGE_DESTINATION_PATH = 'uploads/images/slides';

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'carousel_slides';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['carousel_id', 'image_path', 'content', 'cta_type', 'cta_title', 'cta_href', 'sort'];
    
    /**
     * The attributes that are nullable by default.
     *
     * @var array
     */
    protected $nullable = ['content', 'cta_type', 'cta_title', 'cta_href', 'sort'];

    /**
     * Set model validation rules.
     * 
     * @return array
     */
    public function rules() {
        return [
            'carousel_id' => 'required|integer',
            'image_path' => 'required',
            'sort' => 'required|int',
            'cta_type' => 'required_with:cta_title,cta_href',
            'cta_title' => 'required_with:cta_type,cta_href',
            'cta_href' => 'required_with:cta_type,cta_title'
        ];
    }

    /**
     * Get the carousel that belongs to slide.
     * 
     * @return array
     */
    public function carousel() {
        return $this->belongsTo('App\Models\Carousel');
    }
    
    /**
     * Check's if slide has a link or not.
     * 
     * @return boolean
     */
    public function hasLink() {
        return !is_null($this->cta_type) && !is_null($this->cta_title) && !is_null($this->cta_href);
    }
    
    /**
     * Check's if slide link is internal or not.
     * 
     * @return boolean
     */
    public function hasInternalLink() {
        return $this->cta_type === static::CTA_TYPE_INTERNAL;
    }
    
    /**
     * Returns the CTA type options.
     * 
     * @return array
     */
    public static function getCTATypeOptions() {
        return [
            ['id' => static::CTA_TYPE_INTERNAL, 'title' => 'Internal'],
            ['id' => static::CTA_TYPE_EXTERNAL, 'title' => 'External']
        ];
    }
    
    /**
     * Return carousel slides.
     * 
     * @param int $carouselId
     * 
     * @return array
     */
    public static function getSlides($carouselId) {
        return static::select('carousel_slides.*')
                ->join('carousels', 'carousels.id', '=', 'carousel_slides.carousel_id')
                ->where('carousels.id', $carouselId)
                ->get();
    }

}
