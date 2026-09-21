<?php

namespace Database\Seeders;

use App;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * The content the app needs to work, and nothing else.
     *
     * These eight are safe to run against any database, including a live one:
     * they only read `database/seeders/data/`, they add and update rather than
     * replace, and none of them touches a user or anything a user made.
     *
     * @var list<class-string<Seeder>>
     */
    private const CONTENT = [
        LevelSeeder::class,
        RolesSeeder::class,
        DowntimeActivitiesSeeder::class,
        ItemsSeeder::class,
        ArmorSkillsSeeder::class,
        MonstersSeeder::class,
        ArmorsSeeder::class,
        WeaponsSeeder::class,
    ];

    /**
     * Demo data, built with factories.
     *
     * Never in production, for two separate reasons. Factories need
     * `fakerphp/faker`, which is `require-dev`, so `composer install --no-dev`
     * leaves it out and `db:seed` died on a missing class rather than on
     * anything meaningful. And HunterSeeder attaches an invented hunter to a
     * real campaign and repoints the membership at it, which against live data
     * is worse than a crash.
     *
     * @var list<class-string<Seeder>>
     */
    private const DEMO = [
        UserSeeder::class,
        CampaignSeeder::class,
        HunterSeeder::class,
    ];

    public function run(): void
    {
        App::setLocale('en');

        $this->call(self::CONTENT);

        if (app()->environment('production')) {
            $this->command?->info('Skipped the demo seeders: this is production.');

            return;
        }

        $this->call(self::DEMO);
    }
}
