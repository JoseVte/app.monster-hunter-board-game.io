<?php

namespace App\Events;

use App\Models\Day;
use App\Models\Campaign;
use Illuminate\Foundation\Events\Dispatchable;

class UserMonsterHunted
{
    use Dispatchable;

    public function __construct(
        public Campaign $campaign,
        public Day $day,
    ) {}
}
