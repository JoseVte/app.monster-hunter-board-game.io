<?php

namespace App\Events;

use App\Models\Campaign;
use Illuminate\Foundation\Events\Dispatchable;

class InvitingCampaignMember
{
    use Dispatchable;

    public function __construct(public Campaign $campaign, public string $email, public string $role)
    {
    }
}
