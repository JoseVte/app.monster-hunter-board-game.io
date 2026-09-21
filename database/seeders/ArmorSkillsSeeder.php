<?php

namespace Database\Seeders;

use Arr;
use App\Models\ArmorSkill;
use Illuminate\Database\Seeder;
use Database\Seeders\Concerns\PrunesRemovedEntries;

class ArmorSkillsSeeder extends Seeder
{
    use PrunesRemovedEntries;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $seeded = [];

        foreach (SeedData::get('armors.skills') as $skill) {
            $seeded[] = $skill['name']['en'];

            $armorSkill = ArmorSkill::updateOrCreate([
                'name->en' => $skill['name']['en'],
            ], Arr::only($skill, ['name', 'description']));
            if (Arr::get($skill, 'bonus-set')) {
                $armorSkill->bonus_set = true;
                $armorSkill->bonus_set_armor = $skill['bonus-set'];
                $armorSkill->save();
            }
        }

        $this->pruneMissing(ArmorSkill::class, $seeded, 'armour skills');
    }
}
