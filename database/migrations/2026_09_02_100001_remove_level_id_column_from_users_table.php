<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table(config('level-up.user.users_table'), function (Blueprint $table): void {
            $table->dropConstrainedForeignId('level_id');
        });
    }

    public function down(): void
    {
        Schema::table(config('level-up.user.users_table'), function (Blueprint $table): void {
            $table->entityForeignId('level_id')->nullable()->constrained(table: config('level-up.tables.levels'));
        });
    }
};
