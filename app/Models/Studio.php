<?php

namespace App\Models;

class Studio extends AppModel {
    
    const IMAGE_DESTINATION_PATH = 'uploads/images/studio';

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'studios';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['username', 'first_name', 'last_name', 'about_me', 'city', 'postcode', 'country', 'image_path', 'header_image_path', 'store_link', 'blog_link', 'public', 'share_favourites'];
    
    /**
     * The attributes that are nullable by default.
     *
     * @var array
     */
    protected $nullable = ['about_me', 'city', 'postcode', 'country', 'image_path', 'header_image_path', 'store_link', 'blog_link'];

    /**
     * Set model validation rules.
     * 
     * @return array
     */
    public function rules() {
        return [
            'username' => ['required', 'max:255', 'regex:/^[a-zA-Z0-9.\-_]+$/', 'unique:studios,username,' . $this->id],
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'store_link' => 'url',
            'blog_link' => 'url',
            'public' => 'boolean',
            'share_favourites' => 'boolean'
        ];
    }
    
    /**
     * Get the user that belongs to studio.
     * 
     * @return array
     */
    public function user() {
        return $this->belongsTo('App\Models\User');
    }
    
    /**
     * Returns the studio's full name.
     * 
     * @return string
     */
    public function getFullName() {
        return formatName([$this->first_name, $this->last_name]);
    }
    
    /**
     * Returns the studio's image path.
     * 
     * @return string
     */
    public function getImagePath() {
        return ($this->image_path) ? $this->image_path : 'images/avatar-placeholder.png';
    }
    
    /**
     * Returns the studio's header image path.
     * 
     * @return string
     */
    public function getHeaderImagePath() {
        return ($this->header_image_path) ? $this->header_image_path : 'images/thumbnail-placeholder.png';
    }
    
    /**
     * Returns the studio's full location.
     * 
     * @return string
     */
    public function getLocation() {
        $array = [];
        if ($this->city) {
            $array[] = $this->city;
        }
        if ($this->country) {
            $array[] = getCountry($this->country)->title;
        }
        return arrayToString($array);
    }
    
    /**
     * Function to perform default actions on events.
     */
    protected static function boot() {
        parent::boot();
        static::creating(function($model) {
            $model->user_id = getAuthenticatedUser()->id;
        });
    }

    /**
     * @param $name
     * @return mixed
     */
    public static function getUsersFromName($name)
    {
        return Studio::where('first_name', 'like', $name)
	        ->orWhere('last_name', 'like', $name)
	        ->orWhere('username', 'like', $name)->get();
    }
}
