<?php

use App\Models\SongList;
use App\Models\SongEffect;
use App\Models\WeaponType;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * A hunting horn plays from one of ten song lists, and which one is printed
     * on its weapon card. A list names three songs; a song is an effect from a
     * shared catalogue, the notes it is played with and how far it reaches.
     *
     * The notes are a JSON column rather than rows: they are an ordered run of
     * two or three colours read together, not things anything else points at.
     */
    public function up(): void
    {
        Schema::create('song_effects', function (Blueprint $table): void {
            $table->id();
            $table->json('name');
            $table->json('description');
            $table->timestamps();
        });

        Schema::create('song_lists', function (Blueprint $table): void {
            $table->id();
            $table->foreignIdFor(WeaponType::class)->constrained();
            $table->json('name');
            $table->integer('position')->default(0);
            $table->timestamps();
        });

        Schema::create('songs', function (Blueprint $table): void {
            $table->id();
            $table->foreignIdFor(SongList::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(SongEffect::class)->constrained();
            $table->integer('range')->default(0);
            $table->json('notes');
            $table->integer('position')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('songs');
        Schema::dropIfExists('song_lists');
        Schema::dropIfExists('song_effects');
    }
};
