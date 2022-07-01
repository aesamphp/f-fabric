<?php

namespace App\Models;

class ReportedComment extends AppModel {
    
    const TYPE_BLOG_ARTICLE = 1;
    const TYPE_DESIGN = 2;
    
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'reported_comments';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['comment_id', 'type_id', 'reason'];

    /**
     * Set model validation rules.
     * 
     * @return array
     */
    public function rules() {
        return [
            'comment_id' => 'required|integer',
            'type_id' => 'required|integer',
            'reason' => 'required'
        ];
    }

    /**
     * Get the user that belongs to comment.
     * 
     * @return array
     */
    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * Get the design that belongs to comment.
     * 
     * @return array
     */
    public function comment() {
        return $this->belongsTo('App\Models\DesignComment');
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
