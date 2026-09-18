<?php

namespace Database\Seeders;

use App\Models\Item;
use Illuminate\Database\Seeder;

class ItemsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (SeedData::get('items') as $type => $items) {
            foreach ($items as $english => $spanish) {
                Item::updateOrCreate(
                    ['name->en' => $english],
                    ['type' => $type, 'name' => ['en' => $english, 'es' => $spanish]],
                );
            }
        }
    }
}
