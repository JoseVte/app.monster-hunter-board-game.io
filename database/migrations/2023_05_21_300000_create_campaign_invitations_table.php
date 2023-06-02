<?php

use App\Models\Campaign;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class() extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('campaign_invitations', function (Blueprint $table): void {
            $table->id();
            $table->foreignIdFor(Campaign::class, 'campaign_id')->constrained()->cascadeOnDelete();
            $table->string('email');
            $table->foreignIdFor(Role::class, 'role_id');
            $table->timestamps();

            $table->unique(['campaign_id', 'email']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campaign_invitations');
    }
};
