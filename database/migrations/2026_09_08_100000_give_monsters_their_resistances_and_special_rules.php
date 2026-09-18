<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

// The seed data has always declared a monster's resistance to each element and
// status, plus bespoke setup/mechanics text for the four monsters with special
// rules (Teostra, Nergigante, Kushala Daora, Kirin), and SeedDataTest already
// validates all of it. None of it ever reached a column, so MonstersSeeder had
// nothing to write it to.
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('monsters', function (Blueprint $table): void {
            $table->unsignedTinyInteger('resistance_fire')->nullable();
            $table->unsignedTinyInteger('resistance_water')->nullable();
            $table->unsignedTinyInteger('resistance_thunder')->nullable();
            $table->unsignedTinyInteger('resistance_ice')->nullable();
            $table->unsignedTinyInteger('resistance_dragon')->nullable();
            $table->unsignedTinyInteger('resistance_paralysis')->nullable();
            $table->unsignedTinyInteger('resistance_poison')->nullable();
            $table->unsignedTinyInteger('resistance_sleep')->nullable();
            $table->unsignedTinyInteger('resistance_nitro')->nullable();
            $table->unsignedTinyInteger('resistance_stun')->nullable();
            $table->json('setup')->nullable();
            $table->json('mechanics')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('monsters', function (Blueprint $table): void {
            $table->dropColumn([
                'resistance_fire', 'resistance_water', 'resistance_thunder',
                'resistance_ice', 'resistance_dragon', 'resistance_paralysis',
                'resistance_poison', 'resistance_sleep', 'resistance_nitro',
                'resistance_stun', 'setup', 'mechanics',
            ]);
        });
    }
};
