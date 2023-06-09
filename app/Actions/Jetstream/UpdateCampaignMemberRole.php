<?php

namespace App\Actions\Jetstream;

use App\Models\User;
use App\Models\Campaign;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Gate;
use App\Events\CampaignMemberUpdated;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class UpdateCampaignMemberRole
{
    public function update(User $user, Campaign $campaign, int $campaignMemberId, string $role): void
    {
        Gate::forUser($user)->authorize('updateCampaignMember', $campaign);

        Validator::make([
            'role' => $role,
        ], [
            'role' => ['required', 'string', Rule::exists('roles', 'name')],
        ])->validate();

        $campaign->users()->updateExistingPivot($campaignMemberId, [
            'role_id' => Role::findByName($role)->id,
        ]);

        CampaignMemberUpdated::dispatch($campaign->fresh(), User::find($campaignMemberId));
    }
}
