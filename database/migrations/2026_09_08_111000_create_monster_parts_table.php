<?php

use App\Models\MonsterDifficulty;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

// The body-part break rows shown under a monster's stats: which part, which
// direction it faces, its defense, how much damage breaks it, and what
// happens when it does.
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('monster_parts', function (Blueprint $table): void {
            $table->id();
            $table->foreignIdFor(MonsterDifficulty::class)->constrained()->cascadeOnDelete();
            $table->string('icon');
            $table->string('direction');
            $table->unsignedTinyInteger('defense');
            $table->unsignedTinyInteger('broken');
            $table->json('ability_broken')->nullable();
            $table->unsignedTinyInteger('position')->default(0);
            $table->timestamps();

            $table->unique(['monster_difficulty_id', 'position']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('monster_parts');
    }
};
