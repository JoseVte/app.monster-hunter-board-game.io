<?php

namespace App\Http\Controllers;

use Inertia\Response;
use Illuminate\Http\Request;
use Laravel\Fortify\Features;
use Laravel\Jetstream\Jetstream;
use Laravel\Jetstream\Http\Controllers\Inertia\UserProfileController;

/**
 * Jetstream's own controller renders this page, and its props are not something
 * a middleware can extend without paying for the query on every other page. This
 * subclass only adds the invitations, and the route in web.php has to be declared
 * after Jetstream's for it to win.
 */
class ProfileController extends UserProfileController
{
    public function show(Request $request): Response
    {
        $this->validateTwoFactorAuthenticationState($request);

        return Jetstream::inertia()->render($request, 'Profile/Show', [
            'confirmsTwoFactorAuthentication' => Features::optionEnabled(Features::twoFactorAuthentication(), 'confirm'),
            'sessions' => $this->sessions($request)->all(),
            'invitations' => $request->user()
                ->sentInvitations()
                ->latest()
                ->get(),
            'invitationLimit' => config('invitations.max_pending_per_user'),
        ]);
    }
}
