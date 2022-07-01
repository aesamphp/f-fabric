<?php

use Illuminate\Database\Seeder;
use App\Models\ShippingZoneBranding;

class ShippingZoneBrandingSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $data = [
            ['zone_id' => 1, 'weight_branding_id' => 1, 'price' => 1],
            ['zone_id' => 1, 'weight_branding_id' => 2, 'price' => 3],
            ['zone_id' => 1, 'weight_branding_id' => 3, 'price' => 5],
            ['zone_id' => 1, 'weight_branding_id' => 4, 'price' => 10],
            ['zone_id' => 1, 'weight_branding_id' => 5, 'price' => 15],
            
            ['zone_id' => 5, 'weight_branding_id' => 4, 'price' => 10],
            ['zone_id' => 5, 'weight_branding_id' => 5, 'price' => 15]
        ];
        foreach ($data as $row) {
            ShippingZoneBranding::create($row);
        }
    }

}
