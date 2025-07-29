<?php

namespace Database\Seeders;

use App\Enums\RoleEnum;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $suppliers = [
            [
                'name' => 'مورد الأول',
                'email' => 'supplier1@ajza.net',
                'full_mobile' => '+966501234567',
                'password' => 'password123',
                'is_active' => true,
                'is_registered' => true,
            ],
            [
                'name' => 'مورد الثاني',
                'email' => 'supplier2@ajza.net',
                'full_mobile' => '+966502345678',
                'password' => 'password123',
                'is_active' => true,
                'is_registered' => true,
            ],
            [
                'name' => 'مورد الثالث',
                'email' => 'supplier3@ajza.net',
                'full_mobile' => '+966503456789',
                'password' => 'password123',
                'is_active' => true,
                'is_registered' => true,
            ],
        ];

        $permissions = json_decode(File::get("database/data/permissions.json"));
        
        $supplierPermissions = collect($permissions)->where('role_name', 'Supplier')->pluck('name')->toArray();

        foreach ($suppliers as $supplierData) {
            $supplier = User::create($supplierData);
            
            $supplier->assignRole(RoleEnum::SUPPLIER);
            
            $supplier->syncPermissions($supplierPermissions);
            
        }


    }
}