<?php

use App\Models\Item;
use App\Models\User;
use App\Models\Campaign;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Support\Facades\Storage;

// `db:seed` with no --class used to run UserSeeder, CampaignSeeder and
// HunterSeeder too. All three build their rows with factories, factories need
// fakerphp/faker, and faker is require-dev, so on a server installed with
// --no-dev the command died on a missing class. Worse if it had not: those
// seeders invent users and attach an invented hunter to a real campaign.

test('the default seed brings the content the app needs', function (): void {
    Storage::fake('public');

    $this->seed(DatabaseSeeder::class);

    expect(Item::count())->toBeGreaterThan(0);
});

test('the default seed creates nothing of its own in production', function (): void {
    Storage::fake('public');
    $this->app['env'] = 'production';

    // --force because db:seed refuses to run unprompted in production, which is
    // also why deploy.sh passes it.
    $this->artisan('db:seed', ['--class' => DatabaseSeeder::class, '--force' => true]);

    expect(User::count())->toBe(0)
        ->and(Campaign::count())->toBe(0)
        ->and(Item::count())->toBeGreaterThan(0);
});
