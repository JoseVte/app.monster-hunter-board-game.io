<?php

use App\Models\Weapon;
use App\Models\Monster;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

// A weapon used to be craftable exactly one way, so the monster it branched from
// and the materials it cost both hung off the weapon itself. Two dual blades can
// be built from either Teostra or Kushala Daora parts, at different prices, which
// that shape cannot express. A weapon now owns one recipe per way of making it.
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('weapon_recipes', function (Blueprint $table): void {
            $table->id();
            $table->foreignIdFor(Weapon::class)->constrained()->cascadeOnDelete();
            $table->string('branch')->nullable();
            $table->foreignIdFor(Monster::class, 'branch_id')->nullable()->constrained('monsters');
            $table->unsignedTinyInteger('position')->default(0);
            $table->timestamps();

            $table->unique(['weapon_id', 'position']);
        });

        Schema::table('count_item_weapon', function (Blueprint $table): void {
            $table->foreignId('weapon_recipe_id')->nullable()->after('weapon_id')->constrained()->cascadeOnDelete();
        });

        $this->moveExistingWeaponsToASingleRecipe();

        Schema::table('weapons', function (Blueprint $table): void {
            $table->dropConstrainedForeignId('branch_id');
            $table->dropColumn('branch');
        });
    }

    private function moveExistingWeaponsToASingleRecipe(): void
    {
        DB::table('weapons')->orderBy('id')->chunkById(200, function ($weapons): void {
            foreach ($weapons as $weapon) {
                $recipeId = DB::table('weapon_recipes')->insertGetId([
                    'weapon_id' => $weapon->id,
                    'branch' => $weapon->branch,
                    'branch_id' => $weapon->branch_id,
                    'position' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                DB::table('count_item_weapon')
                    ->where('weapon_id', $weapon->id)
                    ->update(['weapon_recipe_id' => $recipeId]);
            }
        });
    }
};
