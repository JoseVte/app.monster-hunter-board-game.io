<?php

namespace App\Models\Traits;

use App\Models\Level;
use App\Models\Experience;
use App\Events\UserLevelledUp;
use Illuminate\Database\Eloquent\Relations\HasOne;

trait HasExperience
{
    public function experience(): HasOne
    {
        return $this->hasOne(Experience::class);
    }

    public function getPoints(): int
    {
        return $this->experience?->experience_points ?? 0;
    }

    public function getLevel(): int
    {
        return $this->experience?->level?->level ?? 0;
    }

    public function addPoints(int $amount): Experience
    {
        if ($this->experience()->doesntExist()) {
            $this->experience()->create([
                'level_id' => $this->levelReachedWith($amount)->id,
                'experience_points' => $amount,
            ]);

            $this->load('experience');
        } else {
            $this->experience->increment('experience_points', $amount);
        }

        $this->levelUp($this->levelReachedWith($this->getPoints())->level);

        return $this->experience;
    }

    public function nextLevelAt(?int $checkAgainst = null, bool $showAsPercentage = false): int
    {
        $nextLevel = Level::firstWhere('level', $checkAgainst ?? $this->getLevel() + 1);

        if (! $nextLevel || $nextLevel->next_level_experience === null) {
            return 0;
        }

        $currentLevel = Level::firstWhere('level', $this->getLevel());

        if (! $currentLevel) {
            return 0;
        }

        $earnedInLevel = $this->getPoints() - ($currentLevel->next_level_experience ?? 0);
        $range = $nextLevel->next_level_experience - ($currentLevel->next_level_experience ?? 0);

        if ($showAsPercentage) {
            return $range > 0 ? (int) ($earnedInLevel / $range * 100) : 0;
        }

        return max(0, $range - $earnedInLevel);
    }

    protected function levelUp(int $to): void
    {
        $previousLevel = $this->getLevel();

        if ($to <= $previousLevel) {
            return;
        }

        $this->experience->level()->associate(Level::firstWhere('level', $to));
        $this->experience->save();

        for ($level = $previousLevel + 1; $level <= $to; $level++) {
            event(new UserLevelledUp(user: $this, level: $level));
        }
    }

    // The curve stores what each level costs to reach, so the level someone holds
    // is the dearest one they can afford. Level one costs nothing and is stored as
    // null, which is why it cannot be found by comparison and is the fallback.
    protected function levelReachedWith(int $points): Level
    {
        return Level::whereNotNull('next_level_experience')
            ->where('next_level_experience', '<=', $points)
            ->orderByDesc('next_level_experience')
            ->first()
            ?? Level::firstOrCreate(['level' => 1], ['next_level_experience' => null]);
    }
}
