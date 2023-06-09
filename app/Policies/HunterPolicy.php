<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Hunter;
use App\Models\Campaign;

class HunterPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user, Campaign $campaign): bool
    {
        return $user->belongsToCampaign($campaign);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Campaign $campaign, Hunter $hunter): bool
    {
        return $user->belongsToCampaign($campaign) && $campaign->hunters->firstWhere('id', $hunter->id);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, Campaign $campaign): bool
    {
        return $user->belongsToCampaign($campaign);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Campaign $campaign, Hunter $hunter): bool
    {
        return $user->belongsToCampaign($campaign) && $campaign->hunters->firstWhere('id', $hunter->id);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Campaign $campaign, Hunter $hunter): bool
    {
        return $user->belongsToCampaign($campaign) && $campaign->hunters->firstWhere('id', $hunter->id);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Campaign $campaign, Hunter $hunter): bool
    {
        return $user->belongsToCampaign($campaign) && $campaign->hunters->firstWhere('id', $hunter->id);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Hunter $hunter, Campaign $campaign): bool
    {
        return $user->belongsToCampaign($campaign) && $campaign->hunters->firstWhere('id', $hunter->id);
    }
}
