<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Every monster in the seed data declares what it drops, and the list was
     * validated but never seeded, so nothing on a screen could say which monster
     * a part came from. A part drops from more than one monster, so it is a
     * pivot rather than a column on the item.
     */
    public function up(): void
    {
        Schema::create('item_monster', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('item_id')->constrained()->cascadeOnDelete();
            $table->foreignId('monster_id')->constrained()->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['item_id', 'monster_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('item_monster');
    }
};
