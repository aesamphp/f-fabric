<?php

use Illuminate\Database\Seeder;
use App\Models\ShippingWeightBranding;

class ShippingWeightBrandingSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $data = [
            ['type_id' => 1, 'title' => 'Royal Mail 2nd Class – 0 – 60 gm', 'max_weight' => 60],
            ['type_id' => 1, 'title' => 'Royal Mail 1st Class Signed For Large Letter – 0 – 0.25 kg', 'max_weight' => 250],
            ['type_id' => 1, 'title' => 'Royal Mail 1st Class Signed For Small Parcel – 0 – 1 kg', 'max_weight' => 1000],
            ['type_id' => 2, 'title' => 'Parcelforce UK  Next Day Courier – 0 – 29.99 kg', 'max_weight' => 29999],
            ['type_id' => 2, 'title' => 'TNT Next Day Courier – 0 – 19.99 kg', 'max_weight' => 19999]
        ];
        foreach ($data as $row) {
            ShippingWeightBranding::create($row);
        }
    }

}
