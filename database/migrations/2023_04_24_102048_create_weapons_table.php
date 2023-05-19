<?php

use App\Models\Monster;
use App\Models\Weapon;
use App\Models\WeaponType;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class() extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('weapons', function (Blueprint $table): void {
            $table->id();
            $table->foreignIdFor(WeaponType::class, 'type_id')->constrained('weapon_types');
            $table->foreignIdFor(Weapon::class, 'parent_id')->nullable()->constrained('weapons');

            $table->json('name');

            $table->boolean('is_default')->default(false);
            $table->foreignIdFor(Monster::class, 'branch_id')->nullable()->constrained('monsters');
            $table->string('branch')->nullable();
            $table->integer('rarity')->default(1);

            $table->integer('defense')->default(0);
            $table->integer('count_attack_1')->default(0);
            $table->integer('count_attack_2')->default(0);
            $table->integer('count_attack_3')->default(0);
            $table->integer('count_attack_4')->default(0);
            $table->integer('count_attack_5')->default(0);

            $table->boolean('has_elemental_attacks')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('weapons');
    }
};
