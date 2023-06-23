<?php

namespace Database\Seeders;

use Arr;
use App\Models\ArmorSkill;
use Illuminate\Database\Seeder;

class ArmorSkillsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (config('seeders.armors.skills') as $skill) {
            $armorSkill = ArmorSkill::create(Arr::only($skill, ['name', 'description']));
            if (Arr::get($skill, 'bonus-set')) {
                $armorSkill->bonus_set = true;
                $armorSkill->bonus_set_armor = $skill['bonus-set'];
                $armorSkill->save();
            }
        }
    }
}
