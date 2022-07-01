<?php

use Illuminate\Database\Seeder;
use App\Models\UserGroup;

class UserGroupsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['title' => 'Administrator'],
            ['title' => 'Customer']
        ];
        foreach ($data as $row) {
            UserGroup::create($row);
        }
    }
}
