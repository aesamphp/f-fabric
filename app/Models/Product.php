<?php

namespace App\Models;

class Product extends AppModel {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'products';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['category_id', 'title', 'sku', 'width', 'width_text', 'height', 'height_text', 'weight'];
    
    /**
     * The attributes that are nullable by default.
     *
     * @var array
     */
    protected $nullable = ['width', 'height'];
    
    /**
     * Set model validation rules.
     * 
     * @return array
     */
    public function rules() {
        return [
            'category_id' => 'required|integer',
            'title' => 'required|max:255',
            'sku' => 'required|max:255|unique:products,sku,' . $this->id,
            'width' => 'numeric|min:1',
            'width_text' => 'required|max:255',
            'height' => 'numeric|min:1',
            'height_text' => 'required|max:255',
            'weight' => 'required|numeric|min:1'
        ];
    }
    
    /**
     * Get the category that belongs to product.
     * 
     * @return array
     */
    public function category() {
        return $this->belongsTo('App\Models\Category');
    }
    
    /**
     * Get the package types that belongs to product.
     * 
     * @return array
     */
    public function packageTypes() {
        return $this->hasMany('App\Models\ProductPackageType');
    }
    
    /**
     * Get the materials that belongs to product.
     * 
     * @return array
     */
    public function productMaterials() {
        return $this->hasMany('App\Models\ProductMaterial');
    }
    
    /**
     * Get the quantity rules that belongs to product.
     * 
     * @return array
     */
    public function productQuantities() {
        return $this->hasMany('App\Models\ProductQuantity');
    }
    
    /**
     * Get the active materials that belongs to product.
     * 
     * @return array
     */
    public function getActiveMaterials() {
        return $this->productMaterials()
                ->select('product_materials.*')
                ->join('materials', 'product_materials.material_id', '=', 'materials.id')
                ->where('materials.disabled', 0)
                ->orderBy('materials.code', 'ASC')
                ->get();
    }
    
    /**
     * Return's the product weight.
     * 
     * @param int $materialId
     * 
     * @return float
     */
    public function getWeight($materialId) {
        $weight = $this->weight;
        if ($this->category_id !== Category::SAMPLES) {
            $material = Material::findOrFail($materialId);
            $widthMeter = ($this->width ? $this->width : $material->max_width) / 1000;
            $heightMeter = $this->height / 1000;
            $weight = ($material->gsm * ($widthMeter * $heightMeter)) * $weight;
        }
        return $weight;
    }

}
