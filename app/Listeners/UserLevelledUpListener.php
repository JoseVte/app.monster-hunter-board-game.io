<?php

namespace App\Listeners;

use App\Models\User;
use App\Enum\AchievementType;
use LevelUp\Experience\Models\Achievement;
use LevelUp\Experience\Events\UserLevelledUp;

class UserLevelledUpListener
{
    public function handle(UserLevelledUp $event): void
    {
        /** @var User $user */
        $user = $event->user;

        $user->allAchievements()
            ->where('type', AchievementType::LEVEL)
            ->each(function (Achievement $achievement) use ($event, $user): void {
                $user->setAchievementProgress($achievement, achievement_progress($event->level, $achievement->type_count));
            });
    }
}
