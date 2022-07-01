<?php

namespace App\Models;

class DesignImage extends AppModel {
    
    const DPI_ACTUAL_MIN = 150;
    const DPI_DISPLAY_MIN = 72;
    const TYPE_ORIGINAL = 1;
    const TYPE_DUPLICATE = 2;
    const TYPE_HIGH_RESOLUTION = 3;
    const TYPE_THUMBNAIL = 4;
    const TYPE_WATERMARK = 5;
    const TYPE_SIMPLE_MIRROR = 6;
    const TYPE_MIRROR = 7;
    const TYPE_BASIC_REPEAT = 8;
    const TYPE_HALF_DROP = 9;
    const TYPE_HALF_BRICK = 10;
    const THUMBNAIL_SIZE_10 = 10;
    const THUMBNAIL_SIZE_20 = 20;
    const THUMBNAIL_SIZE_50 = 50;
    const IMAGE_DESTINATION_PATH = 'uploads/designs';
    const IMAGE_DESTINATION_TMP_PATH = 'uploads/designs/tmp';
    const WATERMARK_IMAGE_PATH = 'images/watermark.png';

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'design_images';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['design_id', 'path', 'type_id'];

    /**
     * Set model validation rules.
     * 
     * @return array
     */
    public function rules() {
        return [
            'design_id' => 'required|integer',
            'path' => 'required|max:255',
            'type_id' => 'required|integer'
        ];
    }
    
    /**
     * Get the design that belongs to image.
     * 
     * @return array
     */
    public function design() {
        return $this->belongsTo('App\Models\Design');
    }
    
    /**
     * Returns design image destination temporary path.
     * 
     * @return string
     */
    public static function getImageDestinationTmpPath() {
        return static::IMAGE_DESTINATION_TMP_PATH . '/' . date('d-m-Y-H-i-s');
    }
    
    /**
     * Returns the thumbnail size options.
     * 
     * @return array
     */
    public static function getThumbnailSizeOptions() {
        return [
            ['id' => static::THUMBNAIL_SIZE_10, 'title' => '10cm x 10cm'],
            ['id' => static::THUMBNAIL_SIZE_20, 'title' => '20cm x 20cm'],
            ['id' => static::THUMBNAIL_SIZE_50, 'title' => '50cm x 50cm']
        ];
    }

}
