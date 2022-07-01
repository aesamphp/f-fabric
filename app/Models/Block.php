<?php

namespace App\Models;

class Block extends AppModel
{
    const CTA_TYPE_INTERNAL = 1;
    const CTA_TYPE_EXTERNAL = 2;

    const DISPLAY_TYPE_3_BLOCK_HOMEPAGE = 1;
    const DISPLAY_TYPE_5_BLOCK_HOMEPAGE = 2;
    const DISPLAY_TYPE_USER_PROFILE_CAROUSEL = 3;

    const IMAGE_DESTINATION_PATH = 'uploads/images/blocks';

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'blocks';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'image_path', 'cta_type', 'cta_title', 'cta_href', 'display_type'];

    /**
     * The attributes that are nullable by default.
     *
     * @var array
     */
    protected $nullable = ['cta_type', 'cta_title', 'cta_href'];

    /**
     * Set model validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|max:250',
            'image_path' => 'required',
            'display_type' => 'required|int'
        ];
    }

    /**
     * Check's if block has a link or not.
     *
     * @return boolean
     */
    public function hasLink()
    {
        return !is_null($this->cta_type) && !is_null($this->cta_title) && !is_null($this->cta_href);
    }

    /**
     * Check's if block link is internal or not.
     *
     * @return boolean
     */
    public function hasInternalLink()
    {
        return $this->cta_type === static::CTA_TYPE_INTERNAL;
    }

    /**
     * Returns the CTA type options.
     *
     * @return array
     */
    public static function getCTATypeOptions()
    {
        return [
            ['id' => static::CTA_TYPE_INTERNAL, 'title' => 'Internal'],
            ['id' => static::CTA_TYPE_EXTERNAL, 'title' => 'External']
        ];
    }

    /**
     * Returns the the display options
     *
     * @return array
     */
    public static function getDisplayTypeOptions()
    {
        return [
            ['id' => static::DISPLAY_TYPE_3_BLOCK_HOMEPAGE, 'title' => 'Display on the 3 blocks on the homepage'],
            ['id' => static::DISPLAY_TYPE_5_BLOCK_HOMEPAGE, 'title' => 'Display on the 5 blocks on the homepage'],
            ['id' => static::DISPLAY_TYPE_USER_PROFILE_CAROUSEL, 'title' => 'Display user carousel on the homepage']
        ];
    }

}
