<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\Request;
use App\Models\CampaignInvitation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rules\Password;
use App\Actions\Jetstream\AddCampaignMember;
use App\Actions\Invitations\RegisterInvitedUser;
use Illuminate\Auth\Access\AuthorizationException;

class CampaignInvitationController extends Controller
{
    /**
     * The link is signed and was emailed to one address, so it is that address
     * joining, never whoever happens to be signed in. Somebody without an
     * account gets the form to make one rather than a login wall they cannot
     * pass, which is the only way onto the platform once registration closes.
     */
    public function accept(Request $request, CampaignInvitation $invitation): Response|RedirectResponse
    {
        $invited = User::where('email', $invitation->email)->first();

        if (! $invited) {
            return Inertia::render('Auth/AcceptCampaignInvitation', [
                'invitation' => $invitation->getKey(),
                'signature' => $request->fullUrl(),
                'email' => $invitation->email,
                'campaign' => $invitation->campaign->name,
            ]);
        }

        if (! $request->user()) {
            return redirect()->guest(route('login'));
        }

        if (! $request->user()->is($invited)) {
            return redirect()->route('dashboard')->with('error', __('This invitation was sent to a different address.'));
        }

        $this->join($invitation);

        return redirect(config('fortify.home'))->banner(
            __('Great! You have accepted the invitation to join the :campaign campaign.', ['campaign' => $invitation->campaign->name]),
        );
    }

    public function acceptAsNewUser(Request $request, CampaignInvitation $invitation, RegisterInvitedUser $registerInvitedUser): RedirectResponse
    {
        if (User::where('email', $invitation->email)->exists()) {
            return redirect()->route('login');
        }

        $attributes = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', Password::default(), 'confirmed'],
        ]);

        $campaign = $invitation->campaign->name;

        $user = DB::transaction(function () use ($attributes, $invitation, $registerInvitedUser): User {
            $user = $registerInvitedUser([
                'name' => $attributes['name'],
                'email' => $invitation->email,
                'password' => Hash::make($attributes['password']),
            ], emailIsTrusted: false);

            $this->join($invitation);

            return $user;
        });

        Auth::login($user);

        return redirect(config('fortify.home'))->banner(
            __('Great! You have accepted the invitation to join the :campaign campaign.', ['campaign' => $campaign]),
        );
    }

    public function destroy(Request $request, CampaignInvitation $invitation): RedirectResponse
    {
        if (! Gate::forUser($request->user())->check('removeCampaignMember', $invitation->campaign)) {
            throw new AuthorizationException;
        }

        $invitation->delete();

        return back(303);
    }

    private function join(CampaignInvitation $invitation): void
    {
        app(AddCampaignMember::class)->add(
            $invitation->campaign->team->owner,
            $invitation->campaign,
            $invitation->email,
            $invitation->role->name,
        );

        $invitation->delete();
    }
}
