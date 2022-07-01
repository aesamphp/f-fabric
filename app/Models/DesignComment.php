<?php

namespace App\Models;

use App\Models\ReportedComment;

class DesignComment extends AppModel {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'design_comments';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['design_id', 'content'];

    /**
     * Set model validation rules.
     * 
     * @return array
     */
    public function rules() {
        return [
            'design_id' => 'required|integer',
            'content' => 'required|validateBlockedTerms'
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
    public function design() {
        return $this->belongsTo('App\Models\Design');
    }
    
    /**
     * Get the reported comments that belongs to comment.
     * 
     * @return array
     */
    public function reportedComments() {
        return $this->hasMany('App\Models\ReportedComment', 'comment_id')->where('type_id', ReportedComment::TYPE_DESIGN);
    }
    
    /**
     * Returns if the user is comment owner or not.
     * 
     * @return boolean
     */
    public function isOwner() {
        return $this->user_id === getAuthenticatedUser()->id;
    }
    
    /**
     * Returns if the user has reported comment or not.
     * 
     * @return boolean
     */
    public function isReported() {
        return $this->reportedComments()->where('user_id', getAuthenticatedUser()->id)->count() > 0;
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
