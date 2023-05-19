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
        foreach (config('seeders.monsters') as $monster => $details) {
            Monster::create([
                'name' => $monster,
                'category' => $details['category'],
                'expansion' => $details['expansion'],
            ]);
        }
    }
}
