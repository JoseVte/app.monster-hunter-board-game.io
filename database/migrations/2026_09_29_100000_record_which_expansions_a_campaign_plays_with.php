<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Which expansions are in play, and whether the timer follows from them.
     *
     * `expansions` holds `App\Enum\MonsterExpansion` case names. A pivot table
     * would need a row per expansion to point at, and an expansion is an enum
     * case rather than a model, so there is nothing to relate to. It is
     * nullable rather than defaulting to `'[]'`: a literal default on a JSON
     * column is an expression in MySQL 8 and a plain value in sqlite, and
     * `Campaign::expansionCases()` reads null as "none" anyway.
     *
     * `max_days_automatic` defaults to false so every campaign that already
     * exists keeps the timer somebody typed for it. The create form ticks it.
     */
    public function up(): void
    {
        Schema::table('campaigns', function (Blueprint $table): void {
            $table->json('expansions')->nullable()->after('alternative_rules');
            $table->boolean('max_days_automatic')->default(false)->after('max_days');
        });
    }

    public function down(): void
    {
        Schema::table('campaigns', function (Blueprint $table): void {
            $table->dropColumn(['expansions', 'max_days_automatic']);
        });
    }
};
