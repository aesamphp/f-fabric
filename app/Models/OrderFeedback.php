<?php

namespace App\Models;

class OrderFeedback extends AppModel {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'order_feedback';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['order_id', 'rating', 'comment'];

    /**
     * Set model validation rules.
     * 
     * @return array
     */
    public function rules() {
        return [
            'order_id' => 'required|integer',
            'rating' => 'required|integer|between:1,5',
            'comment' => 'required'
        ];
    }
    
    /**
     * Get the user that belongs to feedback.
     * 
     * @return array
     */
    public function user() {
        return $this->belongsTo('App\Models\User');
    }
    
    /**
     * Get the order that belongs to feedback.
     * 
     * @return array
     */
    public function order() {
        return $this->belongsTo('App\Models\Order');
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
