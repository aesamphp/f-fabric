<?php

namespace App\Models;

class Community extends AppModel {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'community';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['email'];

    /**
     * Set model validation rules.
     * 
     * @return array
     */
    public function rules() {
        return [
            'email' => 'required|email|max:255|unique:community,email,' . $this->id
        ];
    }

}
