<?php

namespace App\Actions\Jetstream;

use App\Models\User;
use App\Models\Campaign;
use Illuminate\Support\Facades\Gate;
use App\Events\CampaignMemberRemoved;
use Illuminate\Auth\Access\AuthorizationException;

class RemoveCampaignMember
{
    public function remove(User $user, Campaign $campaign, User $campaignMember): void
    {
        $this->authorize($user, $campaign, $campaignMember);

        $campaign->users()->detach($campaignMember);

        CampaignMemberRemoved::dispatch($campaign, $campaignMember);
    }

    protected function authorize(User $user, Campaign $campaign, User $campaignMember): void
    {
        if ($user->id !== $campaignMember->id
            && !Gate::forUser($user)->check('removeCampaignMember', $campaign)) {
            throw new AuthorizationException();
        }
    }
}
