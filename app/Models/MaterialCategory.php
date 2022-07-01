<?php

namespace App\Models;

class MaterialCategory extends AppModel
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'material_categories';

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

    /**
     * Get the materials that belongs to the material group
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function materials()
    {
        return $this->hasMany(Material::class);
    }

}
