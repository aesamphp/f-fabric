<?php

namespace App\Models;

class DesignAdditionalImage extends AppModel {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'design_additional_images';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['design_id', 'path'];

    /**
     * Set model validation rules.
     * 
     * @return array
     */
    public function rules() {
        return [
            'design_id' => 'required|integer',
            'path' => 'required|max:255'
        ];
    }

}
