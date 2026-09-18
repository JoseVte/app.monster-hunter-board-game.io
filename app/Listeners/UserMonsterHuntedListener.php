<?php

namespace App\Listeners;

use App\Models\User;
use App\Models\Achievement;
use App\Enum\AchievementType;
use App\Events\UserMonsterHunted;

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
