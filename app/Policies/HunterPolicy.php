<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Hunter;
use App\Models\Campaign;

/**
 * Every rule takes the campaign from the URL as well as the hunter, because
 * the routes outside the resource are not scoped: a hunter reached through a
 * campaign it does not belong to is refused here rather than served.
 */
class HunterPolicy
{
    public function viewAny(User $user, Campaign $campaign): bool
    {
        return $user->belongsToCampaign($campaign);
    }

    public function view(User $user, Hunter $hunter, Campaign $campaign): bool
    {
        if (! $hunter->campaign()->is($campaign)) {
            return false;
        }

        return $user->belongsToCampaign($campaign);
    }

    public function create(User $user, Campaign $campaign): bool
    {
        return $user->belongsToCampaign($campaign);
    }

    /**
     * Covers the hunter's sheet as a whole: the name, the parts they carry,
     * crafting, equipping and the weapon they hunt with.
     */
    public function update(User $user, Hunter $hunter, Campaign $campaign): bool
    {
        return $this->managesHunter($user, $hunter, $campaign);
    }

    /**
     * An administrator may remove the member who plays a hunter, or delete the
     * whole campaign, so they may also delete the hunter on its own.
     */
    public function delete(User $user, Hunter $hunter, Campaign $campaign): bool
    {
        if (! $hunter->campaign()->is($campaign)) {
            return false;
        }

        if ($user->hasCampaignRole($campaign, 'admin-campaign')) {
            return true;
        }

        return $this->managesHunter($user, $hunter, $campaign);
    }

    /**
     * The owner of the campaign looks after every hunter in it, and a player
     * looks after their own. Nobody else in the party edits a hunter that is
     * not theirs.
     */
    protected function managesHunter(User $user, Hunter $hunter, Campaign $campaign): bool
    {
        if (! $hunter->campaign()->is($campaign)) {
            return false;
        }

        if ($user->ownsCampaign($campaign)) {
            return true;
        }

        if (! $user->hasCampaignRole($campaign, 'member-campaign') && ! $user->hasCampaignRole($campaign, 'admin-campaign')) {
            return false;
        }

        return $campaign->users()
            ->wherePivot('hunter_id', $hunter->id)
            ->whereKey($user->id)
            ->exists();
    }
}
