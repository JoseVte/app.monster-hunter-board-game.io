<?php

namespace App\Events;

use App\Models\User;
use App\Models\Campaign;
use Illuminate\Foundation\Events\Dispatchable;

class CampaignMemberAdded
{
    use Dispatchable;

    public function __construct(public Campaign $campaign, public User $user)
    {
    }
}
