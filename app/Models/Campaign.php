<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Pivot\CampaignMembership;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use AjCastro\EagerLoadPivotRelations\EagerLoadPivotTrait;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

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

    protected $appends = [
        'description_parsed',
        'description_parsed_html',
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
        return $this->hasMany(Day::class, 'campaign_id')->orderBy('number');
    }

    public function campaignInvitations(): HasMany
    {
        return $this->hasMany(CampaignInvitation::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, CampaignMembership::class)
            ->withPivot(['role_id', 'hunter_id'])
            ->withTimestamps()
            ->as('membership');
    }

    public function getDescriptionParsedAttribute(): string
    {
        return strip_tags(Str::markdown($this->description));
    }

    public function getDescriptionParsedHtmlAttribute(): string
    {
        return Str::markdown($this->description);
    }

    public function hasUserWithEmail(string $email): bool
    {
        return $this->users->contains(fn ($user) => $user->email === $email);
    }
}
