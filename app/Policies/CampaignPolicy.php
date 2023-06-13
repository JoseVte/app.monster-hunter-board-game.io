<?php

namespace App\Policies;

use App\Models\Hunter;
use App\Models\User;
use App\Models\Campaign;
use Illuminate\Auth\Access\HandlesAuthorization;

class CampaignPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Campaign $campaign): bool
    {
        return $user->belongsToCampaign($campaign);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Campaign $campaign, Hunter $hunter = null): bool
    {
        return (
            $user->ownsCampaign($campaign) || (
                $hunter !== null && $user->belongsToCampaign($campaign) && $campaign->users()->wherePivot('hunter_id', $hunter->id)->find($user->id)
            )
        ) && ($user->hasCampaignRole($campaign, 'member-campaign') || $user->hasCampaignRole($campaign, 'admin-campaign'));
    }

    /**
     * Determine whether the user can add campaign members.
     */
    public function addCampaignMember(User $user, Campaign $campaign): bool
    {
        return $user->ownsCampaign($campaign) || $user->hasCampaignRole($campaign, 'admin-campaign');
    }

    /**
     * Determine whether the user can update campaign member permissions.
     */
    public function updateCampaignMember(User $user, Campaign $campaign): bool
    {
        return $user->ownsCampaign($campaign) || $user->hasCampaignRole($campaign, 'admin-campaign');
    }

    /**
     * Determine whether the user can remove campaign members.
     */
    public function removeCampaignMember(User $user, Campaign $campaign): bool
    {
        return $user->ownsCampaign($campaign) || $user->hasCampaignRole($campaign, 'admin-campaign');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Campaign $campaign): bool
    {
        return $user->ownsCampaign($campaign) || $user->hasCampaignRole($campaign, 'admin-campaign');
    }
}
