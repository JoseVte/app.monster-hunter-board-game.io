<?php

namespace App\Models\Traits;

use Exception;
use App\Models\Achievement;
use App\Events\AchievementAwarded;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait HasAchievements
{
    public function allAchievements(): BelongsToMany
    {
        return $this->belongsToMany(Achievement::class)->withPivot('progress');
    }

    public function achievements(): BelongsToMany
    {
        return $this->allAchievements()
            ->withTimestamps()
            ->where('is_secret', false);
    }

    public function achievementsWithProgress(): BelongsToMany
    {
        return $this->achievements()->wherePivotNotNull('progress');
    }

    /**
     * @throws Exception
     */
    public function grantAchievement(Achievement $achievement, ?int $progress = null): void
    {
        if ($progress > 100) {
            throw new Exception(message: 'Progress cannot be greater than 100');
        }

        if ($this->allAchievements()->find($achievement->id)) {
            throw new Exception(message: 'User already has this Achievement');
        }

        $this->achievements()->attach($achievement, [
            'progress' => $progress,
        ]);

        $this->when(
            value: $progress === null || $progress === 100,
            callback: fn (): ?array => event(new AchievementAwarded(achievement: $achievement, user: $this)),
        );
    }
}
