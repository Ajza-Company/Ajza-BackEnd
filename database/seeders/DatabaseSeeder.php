<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        $this->call([
            RoleSeeder::class,
            LocaleSeeder::class,
            CarBrandSeeder::class,
            CarBrandLocaleSeeder::class,
            CarModelSeeder::class,
            CarModelLocaleSeeder::class,
            CarTypeSeeder::class,
            CarTypeLocaleSeeder::class,
            CategorySeeder::class,
            CategoryLocaleSeeder::class,
            CountrySeeder::class,
            StoreSeeder::class,
            StoreLocaleSeeder::class,
        ]);

        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}
