<?php

namespace Database\Seeders;

use App\Models\ArmorAbility;
use Arr;
use Illuminate\Database\Seeder;

class ArmorAbilitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (config('seeders.armors.abilities') as $ability) {
            $armorAbility = ArmorAbility::create(Arr::only($ability, ['name', 'description']));
            if (Arr::get($ability, 'bonus-set')) {
                $armorAbility->bonus_set = true;
                $armorAbility->bonus_set_armor = $ability['bonus-set'];
                $armorAbility->save();
            }
        }
    }
}
