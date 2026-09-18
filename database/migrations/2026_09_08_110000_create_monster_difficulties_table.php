<?php

use App\Models\Monster;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

// One row per difficulty tier (Easy/Normal/Hard) a monster is fought at, each
// carrying the stats that change between tiers: stars, health and the
// monster's ability at that tier.
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('monster_difficulties', function (Blueprint $table): void {
            $table->id();
            $table->foreignIdFor(Monster::class)->constrained()->cascadeOnDelete();
            $table->string('difficulty');
            $table->unsignedTinyInteger('stars');
            $table->unsignedSmallInteger('health');
            $table->json('ability_name');
            $table->json('ability_description');
            $table->timestamps();

            $table->unique(['monster_id', 'difficulty']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('monster_difficulties');
    }
};
