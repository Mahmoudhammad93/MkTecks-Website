<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Role::create([
            'name'=>'owner',
            'display_name_ar'=> 'Admin',
            'display_name_en'=> 'المشرف العام',
            'description_ar'=> 'يستطيع عمل اى شىء',
            'description_en'=> 'Can Do Any Thing',
        ]);
    }
}
