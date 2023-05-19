<?php

use App\Models\Weapon;
use App\Models\WeaponAttack;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class() extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('count_weapon_attack_remove', function (Blueprint $table): void {
            $table->id();
            $table->foreignIdFor(Weapon::class)->constrained();
            $table->foreignIdFor(WeaponAttack::class)->constrained();

            $table->integer('number');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('count_weapon_attack_remove');
    }
};
