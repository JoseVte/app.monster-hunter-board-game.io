<?php

namespace Database\Seeders;

use Str;
use App\Models\Item;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class ItemsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $storage = Storage::disk(config('jetstream.profile_photo_disk', 'public'));

        foreach (SeedData::get('items') as $type => $items) {
            foreach ($items as $english => $spanish) {
                $iconFile = resource_path('images/items/'.Str::slug($english).'.png');

                Item::updateOrCreate(
                    ['name->en' => $english],
                    [
                        'type' => $type,
                        'name' => ['en' => $english, 'es' => $spanish],
                        'icon_path' => is_file($iconFile)
                            ? $storage->putFileAs('items', $iconFile, Str::slug($english).'.png', 'public')
                            : null,
                    ],
                );
            }
        }
    }
}
