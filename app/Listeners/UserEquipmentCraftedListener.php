<?php

namespace App\Listeners;

use App\Models\Weapon;
use App\Enum\AchievementType;
use App\Events\UserEquipmentCrafted;
use LevelUp\Experience\Models\Achievement;

class UserEquipmentCraftedListener
{
    /**
     * Handle the event.
     */
    public function handle(UserEquipmentCrafted $event): void
    {
        $user = $event->user;
        $user->addPoints($event->equipment->rarity);

        $isWeapon = $event->equipment instanceof Weapon;

        $type = $isWeapon ? AchievementType::WEAPON : AchievementType::ARMOR;
        $crafted = $isWeapon ? $user->craftedWeaponsCount() : $user->craftedArmorsCount();

        $user->allAchievements()
            ->where('type', $type)
            ->each(function (Achievement $achievement) use ($user, $crafted): void {
                $user->setAchievementProgress($achievement, achievement_progress($crafted, $achievement->type_count));
            });
    }
}
