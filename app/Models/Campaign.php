<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use App\Models\Pivot\CampaignMembership;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use AjCastro\EagerLoadPivotRelations\EagerLoadPivotTrait;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Campaign extends Model
{
    use EagerLoadPivotTrait;
    use HasFactory;

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

    /**
     * Delete the campaign and everything that hangs off it.
     *
     * The order is forced by the schema rather than chosen: the hunters go
     * first so their own `deleting` hook clears the pivots that point at both a
     * hunter and a day, then the days, then the memberships. Every one of those
     * foreign keys is RESTRICT, so doing it in any other order fails.
     *
     * Hunters are deleted one at a time on purpose. A mass delete on the
     * relation fires no model events, so the hook that makes this work would
     * never run.
     */
    public function purge(): void
    {
        DB::transaction(function (): void {
            $this->hunters->each->delete();
            $this->days()->delete();
            $this->users()->detach();
            $this->delete();
        });
    }

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
        return strip_tags($this->description_parsed_html);
    }

    /**
     * The description is user authored markdown that reaches other members through
     * `v-html`, so raw HTML is dropped and unsafe link schemes are not rendered.
     */
    public function getDescriptionParsedHtmlAttribute(): string
    {
        return Str::markdown($this->description ?? '', [
            'html_input' => 'strip',
            'allow_unsafe_links' => false,
        ]);
    }

    public function hasUserWithEmail(string $email): bool
    {
        return $this->users->contains(fn ($user) => $user->email === $email);
    }
}
