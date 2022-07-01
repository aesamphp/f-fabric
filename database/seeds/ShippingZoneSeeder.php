<?php

use Illuminate\Database\Seeder;
use App\Models\ShippingZone;

class ShippingZoneSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $data = [
            ['title' => 'UK'],
            ['title' => 'Ireland Republic'],
            ['title' => 'Europe – North'],
            ['title' => 'Europe – South'],
            ['title' => 'USA'],
            ['title' => 'Middle East'],
            ['title' => 'Africa'],
            ['title' => 'Asia'],
            ['title' => 'Australia'],
            ['title' => 'South America']
        ];
        foreach ($data as $row) {
            ShippingZone::create($row);
        }
    }

}
