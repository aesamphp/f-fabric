<?php

namespace App\Models;

class UserGroup extends AppModel {

    /**
     * User group codes
     */
    const GROUP_ADMIN = 1;
    const GROUP_CUSTOMER = 2;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'user_groups';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title'];

    /**
     * Set model validation rules.
     * 
     * @return array
     */
    public function rules() {
        return [
            'title' => 'required|max:255'
        ];
    }

}
