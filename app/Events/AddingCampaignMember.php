<?php

namespace App\Events;

use App\Models\User;
use App\Models\Campaign;
use Illuminate\Foundation\Events\Dispatchable;

class AddingCampaignMember
{
    use Dispatchable;

    public function __construct(public Campaign $campaign, public User $user)
    {
    }
}
