<?php

namespace App\Models;

class DesignType extends AppModel {
    
    const TYPE_CENTER = 0;
    const TYPE_BASIC = 1;
    const TYPE_HALF_DROP = 2;
    const TYPE_HALF_BRICK = 3;
    const TYPE_MIRROR = 4;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'design_types';

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
