<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a new admin user
        $adminUser = User::create([
            'name' => 'Test Admin',
            'email' => 'testadmin@ajza.net',
            'full_mobile' => '+966501234500',
            'password' => Hash::make('password123'),
            'gender' => 'male',
            'is_active' => true,
        ]);

        // Assign admin role
        $adminRole = Role::where('name', 'Admin')->first();
        if ($adminRole) {
            $adminUser->assignRole($adminRole);
        }

        $this->command->info('Test Admin user created successfully!');
        $this->command->info('Email: testadmin@ajza.net');
        $this->command->info('Password: password123');
    }
}
