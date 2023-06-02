<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create(['name' => 'admin', 'guard_name' => 'web']);
        Role::create(['name' => 'standard', 'guard_name' => 'web']);

        Role::create(['name' => 'admin-campaign', 'guard_name' => 'sanctum']);
        Role::create(['name' => 'member-campaign', 'guard_name' => 'sanctum']);
    }
}
