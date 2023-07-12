<?php

use App\Models\Monster;
use App\Models\Campaign;
use App\Models\DowntimeActivity;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class() extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('days', function (Blueprint $table): void {
            $table->id();
            $table->foreignIdFor(Campaign::class)->constrained();
            $table->foreignIdFor(Monster::class)->nullable()->constrained();
            $table->foreignIdFor(DowntimeActivity::class)->nullable()->constrained();

            $table->integer('number');
            $table->string('difficulty')->nullable();
            $table->boolean('hunted')->default(false);
            $table->boolean('all_hunters_same_activity')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('days');
    }
};
