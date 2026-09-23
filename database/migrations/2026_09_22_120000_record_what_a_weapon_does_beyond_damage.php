<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * The element a weapon's attacks carry and the statuses they can inflict.
     * Both were declared in the seed data from the start and read by nothing.
     *
     * The element is a column rather than a list because every entry in the data
     * names exactly one; the statuses are a list because a weapon can inflict
     * two, and they are a small closed set rather than rows worth a table.
     */
    public function up(): void
    {
        Schema::table('weapons', function (Blueprint $table): void {
            $table->string('element')->nullable()->after('has_elemental_attacks');
            $table->json('status_attacks')->nullable()->after('element');
        });
    }

    public function down(): void
    {
        Schema::table('weapons', function (Blueprint $table): void {
            $table->dropColumn(['element', 'status_attacks']);
        });
    }
};
