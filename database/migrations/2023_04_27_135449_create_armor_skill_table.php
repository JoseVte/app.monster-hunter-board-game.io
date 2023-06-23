<?php

use App\Models\Armor;
use App\Models\ArmorSkill;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class() extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('armor_skill', function (Blueprint $table): void {
            $table->id();

            $table->foreignIdFor(Armor::class)->constrained();
            $table->foreignIdFor(ArmorSkill::class)->constrained();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('armor_skill');
    }
};
