<?php

namespace App\Models;

class USState extends AppModel {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'us_states';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'code'];

    /**
     * Set model validation rules.
     * 
     * @return array
     */
    public function rules() {
        return [
            'title' => 'required|max:255',
            'code' => 'required|max:255|unique:countries,code,' . $this->id
        ];
    }

}
