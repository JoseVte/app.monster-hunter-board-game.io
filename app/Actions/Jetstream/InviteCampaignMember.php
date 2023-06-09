<?php

namespace App\Actions\Jetstream;

use Closure;
use App\Models\User;
use App\Models\Campaign;
use Illuminate\Validation\Rule;
use App\Mail\CampaignInvitation;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use App\Events\InvitingCampaignMember;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Validator;

class InviteCampaignMember
{
    public function invite(User $user, Campaign $campaign, string $email, string $role = null): void
    {
        Gate::forUser($user)->authorize('addCampaignMember', $campaign);

        $this->validate($campaign, $email, $role);

        InvitingCampaignMember::dispatch($campaign, $email, $role);

        $invitation = $campaign->campaignInvitations()->create([
            'email' => $email,
            'role_id' => Role::findByName($role)->id,
        ]);

        Mail::to($email)->send(new CampaignInvitation($invitation));
    }

    protected function validate(Campaign $campaign, string $email, ?string $role): void
    {
        Validator::make([
            'email' => $email,
            'role' => $role,
        ], $this->rules($campaign), [
            'email.unique' => __('This user has already been invited to the campaign.'),
        ])->after(
            $this->ensureUserIsNotAlreadyOnCampaign($campaign, $email)
        )->validateWithBag('addCampaignMember');
    }

    protected function rules(Campaign $campaign): array
    {
        return array_filter([
            'email' => [
                'required', 'email',
                Rule::unique('campaign_invitations')->where(function (Builder $query) use ($campaign): void {
                    $query->where('campaign_id', $campaign->id);
                }),
            ],
            'role' => ['required', 'string', Rule::exists('roles', 'name')],
        ]);
    }

    /**
     * Ensure that the user is not already on the campaign.
     */
    protected function ensureUserIsNotAlreadyOnCampaign(Campaign $campaign, string $email): Closure
    {
        return function ($validator) use ($campaign, $email): void {
            $validator->errors()->addIf(
                $campaign->hasUserWithEmail($email),
                'email',
                __('This user already belongs to the campaign.')
            );
        };
    }
}
