<?php

namespace App\Models;

class Setting extends AppModel {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'settings';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['path', 'value'];
    
    /**
     * The attributes that are nullable by default.
     *
     * @var array
     */
    protected $nullable = ['value'];

    /**
     * Set model validation rules.
     * 
     * @return array
     */
    public function rules() {
        return [
            'path' => 'required|max:255|unique:settings,path,' . $this->id
        ];
    }
    
    /**
     * Get the field that belongs to setting.
     * 
     * @return array
     */
    public function field() {
        return $this->hasOne('App\Models\SettingField');
    }
    
    /**
     * Returns the setting value.
     * 
     * @param string $path
     * 
     * @return string
     */
    public static function getSettingValue($path) {
        return static::where('path', $path)
                ->firstOrFail()
                ->value;
    }

}
