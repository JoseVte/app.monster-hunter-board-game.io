<?php

namespace App\Actions\Jetstream;

use DB;
use Closure;
use Throwable;
use App\Models\User;
use App\Models\Campaign;
use Illuminate\Validation\Rule;
use Laravel\Jetstream\Jetstream;
use Spatie\Permission\Models\Role;
use App\Events\CampaignMemberAdded;
use App\Events\AddingCampaignMember;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Laravel\Jetstream\Events\TeamMemberAdded;
use Laravel\Jetstream\Events\AddingTeamMember;

class AddCampaignMember
{
    /**
     * @throws Throwable
     */
    public function add(User $user, Campaign $campaign, string $email, string $role = null): void
    {
        Gate::forUser($user)->authorize('addCampaignMember', $campaign);

        $this->validate($campaign, $email, $role);

        $newCampaignMember = Jetstream::findUserByEmailOrFail($email);

        AddingCampaignMember::dispatch($campaign, $newCampaignMember);
        AddingTeamMember::dispatch($campaign->team, $newCampaignMember);

        DB::transaction(function () use ($role, $newCampaignMember, $campaign): void {
            $campaign->users()->attach(
                $newCampaignMember,
                ['role_id' => Role::findByName($role)->id]
            );

            if (!$campaign->team->hasUser($newCampaignMember)) {
                $campaign->team->users()->attach(
                    $newCampaignMember,
                    ['role' => 'editor']
                );
            }
        });

        CampaignMemberAdded::dispatch($campaign, $newCampaignMember);
        TeamMemberAdded::dispatch($campaign->team, $newCampaignMember);
    }

    protected function validate(Campaign $campaign, string $email, ?string $role): void
    {
        Validator::make([
            'email' => $email,
            'role' => $role,
        ], $this->rules(), [
            'email.exists' => __('We were unable to find a registered user with this email address.'),
        ])->after(
            $this->ensureUserIsNotAlreadyOnCampaign($campaign, $email)
        )->validateWithBag('addCampaignMember');
    }

    protected function rules(): array
    {
        return array_filter([
            'email' => ['required', 'email', 'exists:users'],
            'role' => ['required', 'string', Rule::exists('roles', 'name')],
        ]);
    }

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
