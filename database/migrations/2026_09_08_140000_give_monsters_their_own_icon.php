<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

// The wiki has only ever shown a generic monster icon, both in the list and
// on a monster's own page. Each monster's real emblem, the same one printed
// on its physical card, is seeded from resources/images/monsters when the
// file is there, and falls back to a generated avatar when it is not.
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('monsters', function (Blueprint $table): void {
            $table->string('icon_path')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('monsters', function (Blueprint $table): void {
            $table->dropColumn('icon_path');
        });
    }
};
