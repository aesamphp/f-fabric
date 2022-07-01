<?php

use Illuminate\Database\Seeder;
use App\Models\UserGroup;
use App\Models\UserRole;
use App\Models\User;

class UserTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $data = [
            [
                'first_name' => 'Alex',
                'last_name' => 'Wills',
                'email' => 'awills14@gmail.com',
                'username' => 'awills14',
                'password' => 'e3creative',
                'group_id' => UserGroup::GROUP_ADMIN,
                'role_id' => UserRole::TYPE_ADMIN
            ],
            [
                'first_name' => 'E3creative',
                'last_name' => 'Ltd',
                'email' => 'hello@e3creative.co.uk',
                'username' => 'e3creative',
                'password' => 'e3creative228',
                'group_id' => UserGroup::GROUP_ADMIN,
                'role_id' => UserRole::TYPE_ADMIN
            ]
        ];
        foreach ($data as $row) {
            User::create($row);
        }
    }

}
