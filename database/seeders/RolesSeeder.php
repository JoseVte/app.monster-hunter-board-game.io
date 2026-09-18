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
        Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        Role::firstOrCreate(['name' => 'standard', 'guard_name' => 'web']);

        Role::firstOrCreate(['name' => 'admin-campaign', 'guard_name' => 'sanctum']);
        Role::firstOrCreate(['name' => 'member-campaign', 'guard_name' => 'sanctum']);
    }
}
