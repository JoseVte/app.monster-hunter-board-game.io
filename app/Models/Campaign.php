<?php

namespace App\Models;

use Illuminate\Support\Str;
use App\Enum\MonsterExpansion;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use App\Models\Pivot\CampaignMembership;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use AjCastro\EagerLoadPivotRelations\EagerLoadPivotTrait;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @typescript string $description_parsed
 * @typescript string $description_parsed_html
 * @typescript Array<App.Enum.MonsterExpansion> $expansions
 */
class Campaign extends Model
{
    use EagerLoadPivotTrait;
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'max_days',
        'max_days_automatic',
        'health_potions',
        'expansions',

        'team_id',
    ];

    protected $casts = [
        'max_days_automatic' => 'boolean',
        'expansions' => 'array',
    ];

    protected $appends = [
        'description_parsed',
        'description_parsed_html',
    ];

    /**
     * How many activities one hunter may perform on a single downtime day.
     *
     * The number is the rule and it holds for every campaign, so it is stated
     * here once: the request that validates a day reads it, and
     * `CampaignController::show` sends it to the page so the two modals that
     * build a day do not write it out again.
     *
     * It was briefly a per-campaign opt-in (`campaigns.alternative_rules`),
     * which the rulebook text does not support: the second entry under
     * `downtime` in `resources/lang/en/campaign-rules.php` states the three
     * flatly, with no alternative attached.
     */
    public const MAX_DOWNTIME_ACTIVITIES = 3;

    /**
     * The campaign timer before any expansion lengthens it, which is what the
     * first downtime rule in `resources/lang/en/campaign-rules.php` states.
     */
    public const BASE_MAX_DAYS = 25;

    /**
     * Keep `max_days` and `max_days_automatic` from ever disagreeing.
     *
     * Written here rather than in the controller so that no path can save a
     * campaign marked automatic while holding a timer somebody typed: the two
     * forms, the factory, the seeders and any future console command all go
     * through `save()`. A campaign on manual keeps whatever it was given.
     */
    protected static function booted(): void
    {
        static::saving(function (self $campaign): void {
            if ($campaign->max_days_automatic) {
                $campaign->max_days = $campaign->suggestedMaxDays();
            }
        });
    }

    /**
     * The expansions in play, as enum cases rather than the stored names.
     *
     * A name the enum no longer declares is dropped instead of throwing: it
     * means a case was renamed, and refusing to load the campaign at all is a
     * worse answer than showing it without an expansion nobody can name.
     *
     * @return Collection<int, MonsterExpansion>
     */
    public function expansionCases(): Collection
    {
        return collect($this->expansions ?? [])
            ->map(fn (string $name): ?MonsterExpansion => MonsterExpansion::tryFromName($name))
            ->filter()
            ->values();
    }

    /**
     * The timer the expansions in play add up to.
     *
     * Shown as a suggestion on both forms even when the campaign is on manual,
     * and written straight into `max_days` when it is not.
     */
    public function suggestedMaxDays(): int
    {
        return self::BASE_MAX_DAYS + $this->expansionCases()
            ->sum(fn (MonsterExpansion $expansion): int => $expansion->extraCampaignDays());
    }

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
