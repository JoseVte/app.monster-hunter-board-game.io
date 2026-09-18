<?php

namespace App\Events;

use App\Models\User;
use App\Models\Armor;
use App\Models\Weapon;
use Illuminate\Foundation\Events\Dispatchable;

class UserEquipmentCrafted
{
    use Dispatchable;

    public function __construct(
        public User $user,
        public Weapon|Armor $equipment,
    ) {}
}
