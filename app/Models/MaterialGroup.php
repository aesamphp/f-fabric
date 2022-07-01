<?php

namespace App\Models;

class MaterialGroup extends AppModel
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'material_groups';

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
    public function rules()
    {
        return [
            'title' => 'required|max:255'
        ];
    }

}
