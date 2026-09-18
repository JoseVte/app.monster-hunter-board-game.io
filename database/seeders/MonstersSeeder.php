<?php

namespace Database\Seeders;

use App\Models\Monster;
use Illuminate\Database\Seeder;

class MonstersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (SeedData::get('monsters') as $monster => $details) {
            Monster::updateOrCreate(
                ['name->en' => $monster],
                [
                    // Most monster names are proper nouns that do not translate,
                    // so only the ones carrying a qualifier declare a Spanish
                    // form and the rest fall back to the English key.
                    'name' => [
                        'en' => $monster,
                        'es' => $details['name'] ?? $monster,
                    ],
                    'category' => $details['category'],
                    'expansion' => $details['expansion'],
                ],
            );
        }
    }
}
