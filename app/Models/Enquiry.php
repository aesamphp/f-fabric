<?php

namespace App\Models;

class Enquiry extends AppModel {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'enquiries';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'phone', 'subject', 'message'];
    
    /**
     * The attributes that are nullable by default.
     *
     * @var array
     */
    protected $nullable = ['phone'];

    /**
     * Set model validation rules.
     * 
     * @return array
     */
    public function rules() {
        return [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'numeric',
            'subject' => 'required|max:255',
            'message' => 'required'
        ];
    }

}
