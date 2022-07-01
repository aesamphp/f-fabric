<?php

use Illuminate\Database\Seeder;
use App\Models\USState;

class USStateSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $data = [
            ['title' => 'Alabama', 'code' => 'AL'],
            ['title' => 'Alaska', 'code' => 'AK'],
            ['title' => 'American Samoa', 'code' => 'AS'],
            ['title' => 'Arizona', 'code' => 'AZ'],
            ['title' => 'Arkansas', 'code' => 'AR'],
            ['title' => 'California', 'code' => 'CA'],
            ['title' => 'Colorado', 'code' => 'CO'],
            ['title' => 'Connecticut', 'code' => 'CT'],
            ['title' => 'Delaware', 'code' => 'DE'],
            ['title' => 'District of Columbia', 'code' => 'DC'],
            ['title' => 'Florida', 'code' => 'FL'],
            ['title' => 'Georgia', 'code' => 'GA'],
            ['title' => 'Guam', 'code' => 'GU'],
            ['title' => 'Hawaii', 'code' => 'HI'],
            ['title' => 'Idaho', 'code' => 'ID'],
            ['title' => 'Illinois', 'code' => 'IL'],
            ['title' => 'Indiana', 'code' => 'IN'],
            ['title' => 'Iowa', 'code' => 'IA'],
            ['title' => 'Kansas', 'code' => 'KS'],
            ['title' => 'Kentucky', 'code' => 'KY'],
            ['title' => 'Louisiana', 'code' => 'LA'],
            ['title' => 'Maine', 'code' => 'ME'],
            ['title' => 'Maryland', 'code' => 'MD'],
            ['title' => 'Massachusetts', 'code' => 'MA'],
            ['title' => 'Michigan', 'code' => 'MI'],
            ['title' => 'Minnesota', 'code' => 'MN'],
            ['title' => 'Mississippi', 'code' => 'MS'],
            ['title' => 'Missouri', 'code' => 'MO'],
            ['title' => 'Montana', 'code' => 'MT'],
            ['title' => 'Nebraska', 'code' => 'NE'],
            ['title' => 'Nevada', 'code' => 'NV'],
            ['title' => 'New Hampshire', 'code' => 'NH'],
            ['title' => 'New Jersey', 'code' => 'NJ'],
            ['title' => 'New Mexico', 'code' => 'NM'],
            ['title' => 'New York', 'code' => 'NY'],
            ['title' => 'North Carolina', 'code' => 'NC'],
            ['title' => 'North Dakota', 'code' => 'ND'],
            ['title' => 'Northern Mariana Islands', 'code' => 'MP'],
            ['title' => 'Ohio', 'code' => 'OH'],
            ['title' => 'Oklahoma', 'code' => 'OK'],
            ['title' => 'Oregon', 'code' => 'OR'],
            ['title' => 'Pennsylvania', 'code' => 'PA'],
            ['title' => 'Puerto Rico', 'code' => 'PR'],
            ['title' => 'Rhode Island', 'code' => 'RI'],
            ['title' => 'South Carolina', 'code' => 'SC'],
            ['title' => 'South Dakota', 'code' => 'SD'],
            ['title' => 'Tennessee', 'code' => 'TN'],
            ['title' => 'Texas', 'code' => 'TX'],
            ['title' => 'Utah', 'code' => 'UT'],
            ['title' => 'Vermont', 'code' => 'VT'],
            ['title' => 'Virgin Islands', 'code' => 'VI'],
            ['title' => 'Virginia', 'code' => 'VA'],
            ['title' => 'Washington', 'code' => 'WA'],
            ['title' => 'West Virginia', 'code' => 'WV'],
            ['title' => 'Wisconsin', 'code' => 'WI'],
            ['title' => 'Wyoming', 'code' => 'WY']
        ];
        foreach ($data as $row) {
            USState::create($row);
        }
    }

}
