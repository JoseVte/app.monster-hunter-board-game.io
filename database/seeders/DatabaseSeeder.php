<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RolesSeeder::class);
        $this->call(UserSeeder::class);

        $this->call(DowntimeActivitiesSeeder::class);
        $this->call(ItemsSeeder::class);
        $this->call(ArmorAbilitiesSeeder::class);
        $this->call(MonstersSeeder::class);
        $this->call(ArmorsSeeder::class);
        $this->call(WeaponsSeeder::class);
    }
}
