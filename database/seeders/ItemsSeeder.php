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
        foreach (config('seeders.items') as $type => $items) {
            foreach ($items as $item) {
                Item::create([
                    'type' => $type,
                    'name' => $item,
                ]);
            }
        }
    }
}
