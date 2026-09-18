<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Every weapon and armour in the seed data declares the box it comes from,
     * and the list was validated by SeedDataTest but never seeded, so nothing
     * could be filtered by expansion.
     *
     * For a weapon it lives on the recipe, beside the branch: the two dual
     * blades pair an expansion with each of their two branches. Anything in a
     * branch generic to every box records none.
     */
    public function up(): void
    {
        Schema::table('weapon_recipes', function (Blueprint $table): void {
            $table->string('expansion')->nullable()->after('branch_id');
        });

        Schema::table('armors', function (Blueprint $table): void {
            $table->string('expansion')->nullable()->after('branch_id');
        });
    }

    public function down(): void
    {
        Schema::table('weapon_recipes', fn (Blueprint $table) => $table->dropColumn('expansion'));
        Schema::table('armors', fn (Blueprint $table) => $table->dropColumn('expansion'));
    }
};
