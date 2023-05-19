<?php

use App\Models\Day;
use App\Models\Hunter;
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
        Schema::create('day_downtime_activity_hunter', function (Blueprint $table): void {
            $table->id();
            $table->foreignIdFor(Day::class)->constrained();
            $table->foreignIdFor(DowntimeActivity::class)->nullable()->constrained();
            $table->foreignIdFor(Hunter::class)->constrained();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('day_downtime_activity_hunter');
    }
};
