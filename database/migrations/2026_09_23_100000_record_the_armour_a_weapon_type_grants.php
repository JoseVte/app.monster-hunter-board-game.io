<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Each weapon type is worth a point of armour in one slot, which a hunter
     * keeps only while nothing of their own is worn there.
     *
     * Stored keyed by slot rather than as the positional list the seed data
     * writes, so neither the page nor a later reader has to remember that head
     * comes first.
     */
    public function up(): void
    {
        Schema::table('weapon_types', function (Blueprint $table): void {
            $table->json('default_armor')->nullable()->after('image_path');
        });
    }

    public function down(): void
    {
        Schema::table('weapon_types', function (Blueprint $table): void {
            $table->dropColumn('default_armor');
        });
    }
};
