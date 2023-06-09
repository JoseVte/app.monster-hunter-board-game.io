<?php

namespace App\Models\Traits;

use App\Models\Campaign;
use Spatie\Permission\Models\Role;

trait HasCampaigns
{
    public function ownsCampaign(?Campaign $campaign): bool
    {
        if (is_null($campaign)) {
            return false;
        }

        return $this->id === $campaign->team->{$this->getForeignKey()};
    }

    public function belongsToCampaign(?Campaign $campaign): bool
    {
        if (is_null($campaign)) {
            return false;
        }

        return $this->ownsCampaign($campaign) || $this->campaigns->contains(fn ($t) => $t->id === $campaign->id);
    }

    public function hasCampaignRole(?Campaign $campaign, string $role): bool
    {
        if (is_null($campaign)) {
            return false;
        }

        if ($this->ownsCampaign($campaign)) {
            return true;
        }

        return $this->belongsToCampaign($campaign) && optional(Role::find($campaign->users->where(
            'id',
            $this->id
        )->first()->membership->role_id))->name === $role;
    }

    public function hasCampaignHunter(?Campaign $campaign): bool
    {
        if (is_null($campaign)) {
            return false;
        }

        return $this->belongsToCampaign($campaign) && $campaign->users->where('id', $this->id)->whereNotNull('membership.hunter_id')->isNotEmpty();
    }
}
