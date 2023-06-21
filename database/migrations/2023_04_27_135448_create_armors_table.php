<?php

use App\Models\Monster;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class() extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('armors', function (Blueprint $table): void {
            $table->id();

            $table->string('type');
            $table->json('name');

            $table->boolean('is_default')->default(false);
            $table->foreignIdFor(Monster::class, 'branch_id')->nullable()->constrained('monsters');
            $table->string('branch')->nullable();
            $table->integer('rarity')->default(1);

            $table->integer('defense')->default(0);
            $table->integer('defense_fire')->default(0);
            $table->integer('defense_water')->default(0);
            $table->integer('defense_thunder')->default(0);
            $table->integer('defense_ice')->default(0);
            $table->integer('defense_dragon')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('armors');
    }
};
