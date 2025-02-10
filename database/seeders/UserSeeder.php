<?php

namespace Database\Seeders;

use App\Enums\PermissionEnum;
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
            'full_mobile' => '+966553275000',
            'password' => '1Alqarawi1',
            'avatar' => fake()->imageUrl(),
            'is_active' => true,
            'is_registered' => true,
        ]);

        $store_owner->assignRole(RoleEnum::SUPPLIER);

        // Assign all supplier permissions
        $permissions = [
            PermissionEnum::SHOW_ALL_PERMISSIONS,
            PermissionEnum::VIEW_ORDERS,
            PermissionEnum::ACCEPT_ORDERS,
            PermissionEnum::VIEW_OFFERS,
            PermissionEnum::CONTROL_OFFER,
            PermissionEnum::VIEW_USERS,
            PermissionEnum::EDIT_USERS,
            PermissionEnum::VIEW_STORES,
            PermissionEnum::EDIT_STORES,
            PermissionEnum::VIEW_CATEGORIES,
            PermissionEnum::EDIT_CATEGORIES,
            PermissionEnum::VIEW_PRODUCTS,
            PermissionEnum::EDIT_PRODUCTS,
            PermissionEnum::VIEW_ORDERS_STATISTICS,
        ];

        foreach ($permissions as $permission) {
            $store_owner->givePermissionTo($permission);
        }
    }
}
