<?php

namespace App\Models;

class SettingField extends AppModel {
    
    const TYPE_TEXT = 1;
    const TYPE_EMAIL = 2;
    const TYPE_SELECT = 3;
    const TYPE_TEXTAREA = 4;
    const TYPE_TELEPHONE = 5;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'setting_fields';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['setting_id', 'type_id', 'label', 'class', 'options'];
    
    /**
     * The attributes that are nullable by default.
     *
     * @var array
     */
    protected $nullable = ['class', 'options'];

    /**
     * Set model validation rules.
     * 
     * @return array
     */
    public function rules() {
        return [
            'setting_id' => 'required|integer',
            'type_id' => 'required|integer',
            'label' => 'required|max:255',
            'class' => 'max:255'
        ];
    }

}
