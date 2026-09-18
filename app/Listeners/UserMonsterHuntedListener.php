<?php

namespace App\Listeners;

use App\Models\User;
use App\Enum\AchievementType;
use App\Events\UserMonsterHunted;
use LevelUp\Experience\Models\Achievement;

class UserMonsterHuntedListener
{
    /**
     * Handle the event.
     */
    public function handle(UserMonsterHunted $event): void
    {
        $event->campaign->users()->each(function (User $user) use ($event): void {
            $user->addPoints($event->day->difficulty->experience());

            $hunted = $user->huntedMonstersCount();

            $user->allAchievements()
                ->where('type', AchievementType::MONSTER)
                ->each(function (Achievement $achievement) use ($user, $hunted): void {
                    $user->setAchievementProgress($achievement, achievement_progress($hunted, $achievement->type_count));
                });
        });
    }
}
