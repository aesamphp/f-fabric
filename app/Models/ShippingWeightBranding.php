<?php

namespace App\Models;

class ShippingWeightBranding extends AppModel {
    
    const TYPE_POST = 1;
    const TYPE_COURIER = 2;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'shipping_weight_brandings';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['type_id', 'title', 'max_weight', 'tracking_link'];
    
    /**
     * The attributes that are nullable by default.
     *
     * @var array
     */
    protected $nullable = ['tracking_link'];

    /**
     * Set model validation rules.
     * 
     * @return array
     */
    public function rules() {
        return [
            'type_id' => 'required|integer',
            'title' => 'required|max:255',
            'max_weight' => 'required|numeric|min:1',
            'tracking_link' => 'url|max:255',
        ];
    }
    
    /**
     * Get the packages that belongs to branding.
     * 
     * @return array
     */
    public function brandingPackages() {
        return $this->hasMany('App\Models\ShippingPackageBranding', 'weight_branding_id');
    }
    
    /**
     * Returns the type title.
     * 
     * @return string
     */
    public function getType() {
        $typeTitle = null;
        $typeOptions = static::getTypeOptions();
        foreach ($typeOptions as $type) {
            if ($type['id'] === $this->type_id) {
                $typeTitle = $type['title'];
            }
        }
        return $typeTitle;
    }
    
    /**
     * Returns the type options.
     * 
     * @return array
     */
    public static function getTypeOptions() {
        return [
            ['id' => static::TYPE_POST, 'title' => 'Post'],
            ['id' => static::TYPE_COURIER, 'title' => 'Courier']
        ];
    }

}
