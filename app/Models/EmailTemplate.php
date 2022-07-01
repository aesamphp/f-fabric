<?php

namespace App\Models;

class EmailTemplate extends AppModel {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'email_templates';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['action_id', 'title', 'subject', 'content'];

    /**
     * Set model validation rules.
     * 
     * @return array
     */
    public function rules() {
        return [
            'action_id' => 'required|integer',
            'title' => 'required|max:255',
            'subject' => 'required|max:255',
            'content' => 'required'
        ];
    }
    
    /**
     * Get the action that belongs to template.
     * 
     * @return array
     */
    public function action() {
        return $this->belongsTo('App\Models\EmailTemplateAction');
    }

}
