<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = \App\Models\User::create([
            'user_type' => 'admin',
            'name' => 'Ahmed Mohsen',
            'email' => 'mohsen@restaurant.com',
            'mobile' => '01005785948',
            'password' => bcrypt('secret'),
        ]);

        $user = \App\Models\User::create([
            'user_type' => 'admin',
            'name' => 'MK Techs',
            'email' => 'mktechs@restaurant.com',
            'mobile' => '33646444',
            'password' => bcrypt('123456'),
        ]);
    }
}
