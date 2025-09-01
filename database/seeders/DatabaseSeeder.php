<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Setting::create([
            'name_ar'=>'MK مطعم',
            'name_en'=>'Mk Restaurant',
        ]);

        $this->call([
            UserSeeder::class,
            PermissionSeeder::class,
        ]);

        $sql = file_get_contents('database/seeders/cities_areas.sql');
        $statements = array_filter(array_map('trim', explode(';', $sql)));
        foreach ($statements as $statement) {
            DB::statement($statement);
        }
    }
}
