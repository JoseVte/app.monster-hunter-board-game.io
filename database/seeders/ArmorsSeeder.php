<?php

namespace Database\Seeders;

use Arr;
use App\Models\Item;
use App\Models\Armor;
use App\Enum\ArmorType;
use App\Models\Monster;
use App\Models\ArmorSkill;
use Illuminate\Database\Seeder;

class ArmorsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (ArmorType::cases() as $type) {
            foreach (config('seeders.armors.'.$type->name) as $armorName => $armorDetails) {
                $armor = Armor::updateOrCreate([
                    'type' => $type->name,
                    'name' => $armorName,
                ], [
                    'type' => $type,
                    'name' => [
                        'en' => $armorName,
                        'es' => Arr::get($armorDetails, 'name', $armorName),
                    ],
                    'branch' => Arr::get($armorDetails, 'branch'),
                    'is_default' => Arr::get($armorDetails, 'default', false),
                    'rarity' => Arr::get($armorDetails, 'rarity', 1),
                    'defense' => Arr::get($armorDetails, 'defense', 0),
                    'defense_fire' => Arr::get($armorDetails, 'defense_fire', 0),
                    'defense_water' => Arr::get($armorDetails, 'defense_water', 0),
                    'defense_ice' => Arr::get($armorDetails, 'defense_ice', 0),
                    'defense_thunder' => Arr::get($armorDetails, 'defense_thunder', 0),
                    'defense_dragon' => Arr::get($armorDetails, 'defense_dragon', 0),
                ]);

                if (Arr::get($armorDetails, 'branch') && Monster::where('name->en', $armorDetails['branch'])->exists()) {
                    $armor->branch_id = Monster::where('name->en', $armorDetails['branch'])->firstOrFail()->id;
                    $armor->save();
                }
                if (Arr::get($armorDetails, 'skill')) {
                    if (ArmorSkill::where('name->en', $armorDetails['skill'])->doesntExist()) {
                        logger('Armor skill: '.$armorDetails['skill']);
                    }

                    $skill = ArmorSkill::where('name->en', $armorDetails['skill'])->firstOrFail();
                    $armor->skills()->attach($skill);
                }

                if (Arr::get($armorDetails, 'items')) {
                    foreach ($armorDetails['items'] as $itemName => $count) {
                        if (Item::where('name->en', $itemName)->doesntExist()) {
                            logger('Item: '.$itemName);
                        }

                        $item = Item::where('name->en', $itemName)->firstOrFail();
                        $armor->items()->attach($item, ['number' => $count]);
                    }
                }
            }
        }

        foreach (config('seeders.armors.skills') as $skill) {
            if (Arr::get($skill, 'bonus-set')) {
                $bonusSet = [];
                foreach ($skill['bonus-set'] as $armorName) {
                    if (Armor::where('name->en', $armorName)->doesntExist()) {
                        logger($armorName);
                    }
                    $armor = Armor::where('name->en', $armorName)->firstOrFail();
                    $bonusSet[] = $armor->id;
                }

                $armorSkill = ArmorSkill::where('name->en', $skill['name']['en'])->firstOrFail();
                $armorSkill->bonus_set = true;
                $armorSkill->bonus_set_armor = $bonusSet;
                $armorSkill->save();
            }
        }
    }
}
