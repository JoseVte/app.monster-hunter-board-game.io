<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('armor_abilities', function (Blueprint $table) {
            $table->id();

            $table->json('name');
            $table->json('description');
            $table->boolean('bonus_set')->default(false);
            $table->json('bonus_set_armor')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('armor_abilities');
    }
};
