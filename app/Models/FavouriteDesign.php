<?php

namespace App\Models;

class FavouriteDesign extends AppModel {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'favourite_designs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['design_id'];

    /**
     * Set model validation rules.
     * 
     * @return array
     */
    public function rules() {
        return [
            'design_id' => 'required|integer'
        ];
    }
    
    /**
     * Get the user that belongs to favourite.
     * 
     * @return array
     */
    public function user() {
        return $this->belongsTo('App\Models\User');
    }
    
    /**
     * Get the design that belongs to favourite.
     * 
     * @return array
     */
    public function design() {
        return $this->belongsTo('App\Models\Design');
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

}
