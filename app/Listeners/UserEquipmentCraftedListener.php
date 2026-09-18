<?php

namespace App\Listeners;

use App\Models\Weapon;
use App\Models\Achievement;
use App\Enum\AchievementType;
use App\Events\UserEquipmentCrafted;

class UserEquipmentCraftedListener
{
    /**
     * Handle the event.
     */
    public function handle(UserEquipmentCrafted $event): void
    {
        $user = $event->user;
        $user->addPoints($event->equipment->rarity);

        $user->crafts()->create([
            'craftable_type' => $event->equipment::class,
            'craftable_id' => $event->equipment->getKey(),
        ]);

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
