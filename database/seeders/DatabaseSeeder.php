<?php

namespace Database\Seeders;

use App;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        App::setLocale('en');

        $this->call(RolesSeeder::class);
        $this->call(UserSeeder::class);

        $this->call(DowntimeActivitiesSeeder::class);
        $this->call(ItemsSeeder::class);
        $this->call(ArmorSkillsSeeder::class);
        $this->call(MonstersSeeder::class);
        $this->call(ArmorsSeeder::class);
        $this->call(WeaponsSeeder::class);

        $this->call(CampaignSeeder::class);
        $this->call(HunterSeeder::class);
    }
}
