<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class FreshDatabaseSeeder extends Seeder
{
    /**
     * Clear and seed the database with fresh data.
     * This seeder will completely reset the database and populate it with sample data.
     */
    public function run(): void
    {
        $this->command->info('🗑️  Clearing database...');
        
        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        
        // Get all table names
        $tables = DB::select('SHOW TABLES');
        $dbName = 'Tables_in_' . env('DB_DATABASE');
        
        foreach ($tables as $table) {
            $tableName = $table->$dbName;
            if ($tableName !== 'migrations') {
                DB::table($tableName)->truncate();
                $this->command->info("   ✓ Cleared table: {$tableName}");
            }
        }
        
        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
        
        $this->command->info('✅ Database cleared successfully!');
        $this->command->info('🌱 Seeding fresh data...');
        
        // Run seeders in the correct order
        $this->call([
            PermissionSeeder::class,
            RoleSeeder::class,
            LocaleSeeder::class,
            UserSeeder::class,
            SupplierSeeder::class,
            CarBrandSeeder::class,
            CategorySeeder::class,
            CountrySeeder::class,
        ]);
        
        $this->command->info('🎉 Database seeded successfully!');
        $this->command->info('');
        $this->command->info('📋 Sample Data Summary:');
        $this->command->info('   👤 Admin User: store@ajza.net / 1Alqarawi1');
        $this->command->info('   🏪 Suppliers: supplier1@ajza.net, supplier2@ajza.net, supplier3@ajza.net / password123');
        $this->command->info('   🌍 Countries, States, Cities: Saudi Arabia data');
        $this->command->info('   🚗 Car Brands: Toyota, Honda, Ford, etc.');
        $this->command->info('   📦 Categories: Car Parts with subcategories');
        $this->command->info('   🌐 Locales: English (en), Arabic (ar)');
    }
}
