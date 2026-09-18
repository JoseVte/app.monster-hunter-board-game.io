<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

// The wiki has only ever shown a generic item icon, both in the list and on
// an item's own page. Each item's real icon, the same one shown in the video
// game's inventory, is seeded from resources/images/items when the file is
// there, and falls back to a generated avatar when it is not.
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('items', function (Blueprint $table): void {
            $table->string('icon_path')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('items', function (Blueprint $table): void {
            $table->dropColumn('icon_path');
        });
    }
};
