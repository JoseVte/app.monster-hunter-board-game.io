<?php

namespace Database\Seeders;

use Arr;
use Str;
use App\Models\Item;
use App\Models\Weapon;
use App\Models\Monster;
use App\Models\WeaponType;
use App\Models\WeaponAttack;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class WeaponsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $storage = Storage::disk(config('jetstream.profile_photo_disk', 'public'));

        foreach (config('seeders.weapons') as $weaponsByType) {
            $weaponType = WeaponType::create([
                'name' => $weaponsByType['name'],
                'description' => $weaponsByType['description'],
                'image_path' => $storage->putFileAs('weapon-types', resource_path('images/'.$weaponsByType['image']), Str::slug($weaponsByType['name']).'.png', 'public'),
            ]);

            foreach (Arr::get($weaponsByType, 'weapons', []) as $weaponDetails) {
                $weapon = Weapon::updateOrCreate([
                    'name' => $weaponDetails['name'],
                    'type_id' => $weaponType->id,
                ], [
                    'name' => $weaponDetails['name'],
                    'type_id' => $weaponType->id,
                    'branch' => Arr::get($weaponDetails, 'branch'),
                    'is_default' => Arr::get($weaponDetails, 'default', false),
                    'has_elemental_attacks' => Arr::get($weaponDetails, 'has_elemental_attacks', false),
                    'rarity' => Arr::get($weaponDetails, 'rarity', 1),
                    'defense' => Arr::get($weaponDetails, 'defense', 0),
                    'count_attack_1' => Arr::get($weaponDetails, 'count_attack_1', 0),
                    'count_attack_2' => Arr::get($weaponDetails, 'count_attack_2', 0),
                    'count_attack_3' => Arr::get($weaponDetails, 'count_attack_3', 0),
                    'count_attack_4' => Arr::get($weaponDetails, 'count_attack_4', 0),
                    'count_attack_5' => Arr::get($weaponDetails, 'count_attack_5', 0),
                ]);

                if (Arr::get($weaponDetails, 'branch') && Monster::where('name->en', $weaponDetails['branch'])->exists()) {
                    $weapon->branch_id = Monster::where('name->en', $weaponDetails['branch'])->firstOrFail()->id;
                    $weapon->save();
                }

                if (Arr::get($weaponDetails, 'parent')) {
                    if (Weapon::where('name->en', $weaponDetails['parent'])->doesntExist()) {
                        logger('Weapon parent: '.$weaponDetails['parent']);
                    }

                    $weapon->parent_id = Weapon::where('name->en', $weaponDetails['parent'])->firstOrFail()->id;
                    $weapon->save();
                }

                if (Arr::get($weaponDetails, 'items')) {
                    foreach ($weaponDetails['items'] as $itemName => $count) {
                        if (Item::where('name->en', $itemName)->doesntExist()) {
                            logger('Item: '.$itemName);
                        }

                        $weaponAttack = Item::where('name->en', $itemName)->firstOrFail();
                        $weapon->items()->attach($weaponAttack, ['number' => $count]);
                    }
                }

                if (Arr::get($weaponDetails, 'attacks')) {
                    if (Arr::get($weaponDetails, 'attacks.remove')) {
                        foreach ($weaponDetails['attacks']['remove'] as $attackName => $count) {
                            if (WeaponAttack::where('name->en', $attackName)->doesntExist()) {
                                logger('Attack name: '.$attackName);
                                WeaponAttack::create(['name' => $attackName]);
                            }

                            $weaponAttack = WeaponAttack::where('name->en', $attackName)->firstOrFail();
                            $weapon->attacksToRemove()->attach($weaponAttack, ['number' => $count]);
                        }
                    }
                    if (Arr::get($weaponDetails, 'attacks.add')) {
                        foreach ($weaponDetails['attacks']['add'] as $attackName => $count) {
                            if (WeaponAttack::where('name->en', $attackName)->doesntExist()) {
                                logger('Attack name: '.$attackName);
                                WeaponAttack::create(['name' => $attackName]);
                            }

                            $weaponAttack = WeaponAttack::where('name->en', $attackName)->firstOrFail();
                            $weapon->attacksToAdd()->attach($weaponAttack, ['number' => $count]);
                        }
                    }
                }
            }
        }
    }
}
