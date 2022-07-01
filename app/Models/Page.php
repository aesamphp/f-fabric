<?php

namespace App\Models;

class Page extends AppModel
{
    const DISABLED = 0;
    const ENABLED = 1;

    const IMAGE_DESTINATION_PATH = 'uploads/images/page';

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'pages';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'url', 'excerpt', 'content', 'meta_description', 'meta_keywords', 'status', 'image_path'];

    /**
     * The attributes that are nullable by default.
     *
     * @var array
     */
    protected $nullable = ['excerpt', 'meta_description', 'meta_keywords'];

    /**
     * Set model validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|max:250',
            'content' => 'required',
            'status' => 'boolean',
            'url' => 'required',
        ];
    }

    /**
     * Function to perform default actions on events.
     */
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->setIdentifier($model->title);
        });
        static::updating(function ($model) {
            $model->setIdentifier($model->title);
        });
    }

    /**
     * Returns the the display options
     *
     * @return array
     */
    public static function getStatusOptions()
    {
        return [
            ['id' => static::DISABLED, 'title' => 'Disabled'],
            ['id' => static::ENABLED, 'title' => 'Enabled'],
        ];
    }
}