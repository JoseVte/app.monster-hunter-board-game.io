<?php

use App\Models\Item;
use App\Models\Monster;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

// The roll-1-to-12 reward table printed alongside a monster's card, plus the
// bonus text a handful of rolls carry for a broken part.
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('monster_rewards', function (Blueprint $table): void {
            $table->id();
            $table->foreignIdFor(Monster::class)->constrained()->cascadeOnDelete();
            $table->unsignedTinyInteger('roll');
            $table->foreignIdFor(Item::class)->constrained();
            $table->json('extra')->nullable();
            $table->timestamps();

            $table->unique(['monster_id', 'roll']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('monster_rewards');
    }
};
