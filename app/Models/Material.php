<?php

namespace App\Models;

class Material extends AppModel
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'materials';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['group_id', 'material_category_id', 'code', 'title', 'composition', 'gsm', 'max_width', 'description', 'machine_name', 'profile'];

    /**
     * The attributes that are nullable by default.
     *
     * @var array
     */
    protected $nullable = ['machine_name', 'profile'];

    /**
     * Set model validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'group_id' => 'integer',
            'material_category_id' => 'integer',
            'code' => 'required|max:255|unique:materials,code,' . $this->id,
            'title' => 'required|max:255',
            'composition' => 'required',
            'gsm' => 'required|numeric|min:1',
            'max_width' => 'required|numeric|min:1',
            'description' => 'required'
        ];
    }

    /**
     * Get the material group that belongs to material.
     *
     * @return array
     */
    public function group()
    {
        return $this->hasOne(MaterialGroup::class);
    }

    /**
     * Get the material group that belongs to material.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(MaterialCategory::class, 'material_category_id');
    }

    public function productMaterial()
    {
        return $this->belongsToMany(ProductMaterial::class)->withPivot('product_id', 'material_id');
    }
}

