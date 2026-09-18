<?php

namespace App\Models;

use Exception;
use App\Enum\AchievementType;
use Laravel\Jetstream\HasTeams;
use Laravel\Sanctum\HasApiTokens;
use App\Events\AchievementAwarded;
use App\Models\Traits\HasCampaigns;
use App\Models\Traits\HasExperience;
use App\Models\Traits\HasAchievements;
use Laravel\Jetstream\HasProfilePhoto;
use Spatie\Permission\Traits\HasRoles;
use App\Models\Pivot\CampaignMembership;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use AjCastro\EagerLoadPivotRelations\EagerLoadPivotTrait;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable implements MustVerifyEmail
{
    use EagerLoadPivotTrait;
    use HasAchievements;
    use HasApiTokens;
    use HasCampaigns;
    use HasExperience;
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

    public function sentInvitations(): HasMany
    {
        return $this->hasMany(Invitation::class, 'inviter_id');
    }

    public function providers(): HasMany
    {
        return $this->hasMany(Provider::class);
    }

    public function hunters(): BelongsToMany
    {
        return $this->belongsToMany(Hunter::class, CampaignMembership::class, 'user_id', 'hunter_id');
    }

    public function crafts(): HasMany
    {
        return $this->hasMany(Craft::class);
    }

    /**
     * Counted from the craft log rather than from what a hunter holds, because
     * an upgrade replaces the weapon it was made from and would otherwise erase
     * the progress it earned.
     */
    public function craftedWeaponsCount(): int
    {
        return $this->crafts()->where('craftable_type', Weapon::class)->count();
    }

    public function craftedArmorsCount(): int
    {
        return $this->crafts()->where('craftable_type', Armor::class)->count();
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
