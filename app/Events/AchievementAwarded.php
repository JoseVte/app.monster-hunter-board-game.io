<?php

namespace App\Events;

use App\Models\User;
use App\Models\Achievement;
use Illuminate\Foundation\Events\Dispatchable;

class AchievementAwarded
{
    use Dispatchable;

    public function __construct(
        public Achievement $achievement,
        public User $user,
    ) {}
}
