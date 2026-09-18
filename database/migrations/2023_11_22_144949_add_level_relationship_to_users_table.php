<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table(config('level-up.user.users_table'), function (Blueprint $table): void {
            $table->foreignId('level_id')
                ->after('remember_token')
                ->nullable()
                ->constrained();
        });
    }

    public function down(): void
    {
        Schema::table(config('level-up.user.users_table'), function (Blueprint $table): void {
            $table->dropConstrainedForeignId('level_id');
        });
    }
};
