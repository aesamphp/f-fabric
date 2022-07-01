<?php

use Illuminate\Database\Seeder;
use App\Models\UserRole;

class UserRolesTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $data = [
            ['title' => 'Administrator'],
            ['title' => 'Manager'],
            ['title' => 'Marketing'],
            ['title' => 'Factory'],
            ['title' => 'Contributor']
        ];
        foreach ($data as $row) {
            UserRole::create($row);
        }
    }

}
