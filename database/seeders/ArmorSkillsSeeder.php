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
            // Only the flag: the pieces are named here but every page that
            // reads them compares against the ids a hunter is wearing, and the
            // armours do not exist yet. `ArmorsSeeder` fills them in once they
            // do. Writing the names meanwhile left a window where a set bonus
            // read as inactive however many pieces were on, and running this
            // seeder on its own reopened it.
            if (Arr::get($skill, 'bonus-set')) {
                $armorSkill->bonus_set = true;
                $armorSkill->save();
            }
        }

        $this->pruneMissing(ArmorSkill::class, $seeded, 'armour skills');
    }
}
