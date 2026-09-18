<?php

use App\Models\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invitations', function (Blueprint $table): void {
            $table->id();

            $table->foreignIdFor(User::class, 'inviter_id')->constrained('users')->cascadeOnDelete();
            $table->string('email')->nullable();
            // A hash, never the token itself, so a leaked database row cannot be
            // turned back into a working invitation link.
            $table->string('token', 64)->unique();
            $table->timestamp('expires_at');
            $table->timestamp('accepted_at')->nullable();
            $table->foreignId('accepted_by_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('revoked_at')->nullable();

            $table->timestamps();

            $table->index('inviter_id');
            $table->index('email');
        });
    }
};
