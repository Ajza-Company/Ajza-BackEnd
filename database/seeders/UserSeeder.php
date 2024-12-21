<?php

namespace Database\Seeders;

use App\Enums\RoleEnum;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $store_owner = User::create([
            "name" => fake()->name(),
            'email' => 'store@ajza.net',
            'full_mobile' => '+201068936567',
            'password' => '12345678',
            'avatar' => fake()->imageUrl(),
            'is_active' => true,
            'is_registered' => true,
        ]);

        $store_owner->assignRole(RoleEnum::STORE_OWNER);
    }
}
