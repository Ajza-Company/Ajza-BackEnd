<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = json_decode(File::get("database/data/permissions.json"));

        foreach ($roles as $value) {
            Permission::firstOrCreate(
                ['name' => $value->name],
                [
                    "friendly_name" => $value->friendly_name,
                    "group_name" => $value->group_name,
                    "guard_name" => $value->guard_name,
                    "role_name" => $value->role_name
                ]
            );
        }
    }
}
