<?php

namespace Database\Seeders;

use App\Models\Campaign;
use App\Models\Item;
use App\Models\User;
use App\Models\Armor;
use App\Models\Hunter;
use App\Models\Weapon;
use Illuminate\Database\Seeder;

class HunterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::where('email', config('seed.users.admin.email'))->firstOrFail();
        /** @var Campaign $campaign */
        $campaign = $user->campaigns()->firstOrFail();

        $campaign->users()->each(function (User $user) use ($campaign) {
            $hunter = Hunter::factory()->create(['campaign_id' => $campaign]);
            $campaign->users()->updateExistingPivot($user->id, ['hunter_id' => $hunter->id]);

            Item::each(static function (Item $item) use ($hunter): void {
                if (fake()->boolean(20)) {
                    $hunter->items()->attach($item, ['number' => fake()->numberBetween(1, 99)]);
                }
            });

            Weapon::each(static function (Weapon $weapon) use ($hunter): void {
                if (!$weapon->is_default && fake()->boolean(20)) {
                    $hunter->weapons()->attach($weapon);
                }
            });

            Armor::each(static function (Armor $armor) use ($hunter): void {
                if (fake()->boolean(20)) {
                    $hunter->armors()->attach($armor);
                }
            });
        });
    }
}
