<?php

namespace App\Models;

class DesignColour extends AppModel {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'design_colours';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['design_id', 'value'];

    /**
     * Set model validation rules.
     * 
     * @return array
     */
    public function rules() {
        return [
            'design_id' => 'required|integer',
            'value' => 'required|size:7'
        ];
    }
    
    /**
     * Returns the allowed colour palettes.
     * 
     * @return array
     */
    public static function getColourPalettes() {
        return [
            ['title' => 'Yellow', 'values' => ['feed01', 'fdca01', 'f9b700','f29b00', 'f5a301']],
            ['title' => 'Red', 'values' => ['e7002a', 'e94e2f', 'e60003','d70007', 'b30006']],
            ['title' => 'Purple', 'values' => ['e60084', 'c80084', 'ad0073','930084', '741186']],
            ['title' => 'Navy', 'values' => ['8d90c5', '6375b7', '3580c3','4470b7', '8ba1d2']],
            ['title' => 'Blue', 'values' => ['01a5ec', '0060aa', '014ea0','1a3793', '2e1d87']],
            ['title' => 'Green', 'values' => ['70b21a', '2fa829', '00a131','019837', '01832d']],
            ['title' => 'Brown', 'values' => ['d1bb92', 'c0a172', '6d5d44','544935', '433b2e']],
            ['title' => 'White', 'values' => ['ffffff', 'fdfeec', 'f3f0e1','efe8d8', 'e5d9c1']],
            ['title' => 'Black', 'values' => ['000000', '3c3c3c', '717171','cdcdcd', 'ffffff']]
        ];
    }

}
