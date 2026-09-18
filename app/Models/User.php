<?php

namespace App\Models;

use Exception;
use App\Enum\AchievementType;
use Laravel\Jetstream\HasTeams;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Traits\HasCampaigns;
use Laravel\Jetstream\HasProfilePhoto;
use Spatie\Permission\Traits\HasRoles;
use App\Models\Pivot\CampaignMembership;
use Illuminate\Notifications\Notifiable;
use LevelUp\Experience\Models\Achievement;
use Laravel\Fortify\TwoFactorAuthenticatable;
use LevelUp\Experience\Concerns\GiveExperience;
use LevelUp\Experience\Concerns\HasAchievements;
use Illuminate\Database\Eloquent\Casts\Attribute;
use LevelUp\Experience\Events\AchievementAwarded;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use AjCastro\EagerLoadPivotRelations\EagerLoadPivotTrait;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    use EagerLoadPivotTrait;
    use GiveExperience;
    use HasAchievements;
    use HasApiTokens;
    use HasCampaigns;
    use HasFactory;
    use HasProfilePhoto {
        profilePhotoUrl as getPhotoUrl;
    }
    use HasRoles;
    use HasTeams;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    protected static function booted(): void
    {
        static::created(function (User $user): void {
            $user->addPoints(0);

            Achievement::where('type', AchievementType::LEVEL)
                ->each(function (Achievement $achievement) use ($user): void {
                    $user->grantAchievement($achievement, achievement_progress($user->getLevel(), $achievement->type_count));
                });

            Achievement::whereIn('type', [AchievementType::MONSTER, AchievementType::WEAPON, AchievementType::ARMOR])
                ->each(function (Achievement $achievement) use ($user): void {
                    $user->grantAchievement($achievement, 0);
                });
        });
        static::deleting(function (User $user): void {
            $user->experienceHistory()->delete();
            $user->experience()->delete();
            $user->allAchievements()->detach();
        });
    }

    /**
     * Get the URL to the user's profile photo.
     */
    public function profilePhotoUrl(): Attribute
    {
        return filter_var($this->profile_photo_path, FILTER_VALIDATE_URL)
            ? Attribute::get(fn () => $this->profile_photo_path)
            : $this->getPhotoUrl();
    }

    public function campaigns(): BelongsToMany
    {
        return $this->belongsToMany(Campaign::class, CampaignMembership::class)
            ->withPivot(['role_id', 'hunter_id'])
            ->withTimestamps()
            ->as('membership');
    }

    public function providers(): HasMany
    {
        return $this->hasMany(Provider::class);
    }

    public function hunters(): BelongsToMany
    {
        return $this->belongsToMany(Hunter::class, CampaignMembership::class, 'user_id', 'hunter_id');
    }

    public function craftedWeaponsCount(): int
    {
        return $this->hunters()->withCount('weapons')->get()->sum('weapons_count');
    }

    public function craftedArmorsCount(): int
    {
        return $this->hunters()->withCount('armors')->get()->sum('armors_count');
    }

    public function huntedMonstersCount(): int
    {
        return Day::whereIn('campaign_id', $this->campaigns()->select('campaigns.id'))
            ->where('hunted', true)
            ->count();
    }

    public function setAchievementProgress(Achievement $achievement, int $progress): void
    {
        if ($progress > 100) {
            throw new Exception(message: 'Progress cannot be greater than 100');
        }

        if (! $this->allAchievements()->find($achievement->id)) {
            throw new Exception(message: 'User already has not this Achievement');
        }

        $this->achievements()->updateExistingPivot($achievement, [
            'progress' => $progress,
        ]);

        $this->when(value: $progress === 100, callback: fn (): ?array => event(new AchievementAwarded(achievement: $achievement, user: $this)));
    }
}
