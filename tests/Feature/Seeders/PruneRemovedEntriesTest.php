<?php

use App\Models\Item;
use App\Models\Hunter;
use Database\Seeders\ItemsSeeder;
use Illuminate\Support\Facades\Storage;

// The seeders match on `name->en`, so renaming an entry in the data files used
// to create a row rather than rename one and leave the old one behind. Nothing
// removed it, nothing pointed at it, and it kept showing up in the wiki.

test('a row the data no longer names is removed', function (): void {
    Storage::fake('public');

    $ghost = Item::create(['type' => 'COMMON', 'name' => ['en' => 'Renamed Away', 'es' => 'Renombrado']]);

    $this->seed(ItemsSeeder::class);

    expect(Item::find($ghost->id))->toBeNull()
        ->and(Item::count())->toBeGreaterThan(0);
});

// Deleting an item a hunter is carrying would be data loss, and the foreign key
// refuses it anyway. The seeder has to survive that and say so rather than
// blow up half way through.
test('a row somebody still owns is kept rather than forced', function (): void {
    Storage::fake('public');

    $ghost = Item::create(['type' => 'COMMON', 'name' => ['en' => 'Still Carried', 'es' => 'Aun llevado']]);
    Hunter::factory()->create()->items()->attach($ghost, ['number' => 1]);

    $this->seed(ItemsSeeder::class);

    expect(Item::find($ghost->id))->not->toBeNull();
});
