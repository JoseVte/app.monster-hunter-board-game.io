<?php

namespace App\Models;

use AjCastro\EagerLoadPivotRelations\EagerLoadPivotTrait;
use Illuminate\Database\Eloquent\Model;
use App\Models\Pivot\CampaignMembership;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Campaign extends Model
{
    use HasFactory;
    use EagerLoadPivotTrait;

    protected $fillable = [
        'name',
        'description',
        'max_days',
        'health_potions',

        'team_id',
    ];

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function hunters(): HasMany
    {
        return $this->hasMany(Hunter::class, 'campaign_id');
    }

    public function days(): HasMany
    {
        return $this->hasMany(Day::class, 'campaign_id');
    }

    public function campaignInvitations(): HasMany
    {
        return $this->hasMany(CampaignInvitation::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, CampaignMembership::class)
            ->withPivot('role_id')
            ->withTimestamps()
            ->as('membership');
    }

    public function hasUserWithEmail(string $email): bool
    {
        return $this->users->contains(fn ($user) => $user->email === $email);
    }
}
