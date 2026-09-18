<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('experience_audits', function (Blueprint $table): void {
            $table->id();
            $table->foreignId(config('level-up.user.foreign_key'))->constrained(config('level-up.user.users_table'));
            $table->integer('points')->index();
            $table->boolean('levelled_up')->default(false);
            $table->unsignedBigInteger('level_to')->nullable();
            $table->enum('type', ['add', 'remove', 'reset', 'level_up']);
            $table->string('reason')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('experience_audits');
    }
};
