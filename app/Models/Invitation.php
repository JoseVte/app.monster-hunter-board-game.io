<?php

namespace App\Models;

use Illuminate\Support\Str;
use App\Enum\InvitationStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Invitation extends Model
{
    protected $fillable = [
        'inviter_id',
        'email',
        'token',
        'expires_at',
    ];

    protected $appends = ['status'];

    protected $hidden = ['token'];

    public static function newToken(): string
    {
        return Str::random(64);
    }

    public static function hashToken(string $token): string
    {
        return hash('sha256', $token);
    }

    public function inviter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'inviter_id');
    }

    public function acceptedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'accepted_by_id');
    }

    /**
     * Derived from the timestamps so the two can never disagree. The order
     * matters: a revoked invitation stays revoked even if it had been accepted.
     */
    public function currentStatus(): InvitationStatus
    {
        if ($this->revoked_at !== null) {
            return InvitationStatus::REVOKED;
        }

        if ($this->accepted_at !== null) {
            return InvitationStatus::ACCEPTED;
        }

        if ($this->expires_at->isPast()) {
            return InvitationStatus::EXPIRED;
        }

        return InvitationStatus::PENDING;
    }

    public function isPending(): bool
    {
        return $this->currentStatus() === InvitationStatus::PENDING;
    }

    public function getStatusAttribute(): string
    {
        return $this->currentStatus()->value;
    }

    public function scopePending(Builder $builder): Builder
    {
        return $builder->whereNull('revoked_at')
            ->whereNull('accepted_at')
            ->where('expires_at', '>=', now());
    }

    public function scopeAccepted(Builder $builder): Builder
    {
        return $builder->whereNull('revoked_at')->whereNotNull('accepted_at');
    }

    public function scopeRevoked(Builder $builder): Builder
    {
        return $builder->whereNotNull('revoked_at');
    }

    public function scopeExpired(Builder $builder): Builder
    {
        return $builder->whereNull('revoked_at')
            ->whereNull('accepted_at')
            ->where('expires_at', '<', now());
    }

    protected function casts(): array
    {
        return [
            'expires_at' => 'datetime',
            'accepted_at' => 'datetime',
            'revoked_at' => 'datetime',
        ];
    }
}
