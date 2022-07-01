<?php

namespace App\Models;

class NotificationBanner extends AppModel
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'notification_banner';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'enabled',
        'text',
        'link',
    ];

    /**
     * The attributes that are nullable by default.
     *
     * @var array
     */
    protected $nullable = [
        'link',
    ];

    public static function getNotificationBanner()
    {
        return static::whereEnabled(true)->oldest()->first();
    }
}
