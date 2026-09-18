<?php

namespace App\Http\Controllers\Auth;

use Inertia\Inertia;
use Inertia\Response;
use App\Models\Invitation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use App\Providers\RouteServiceProvider;
use Illuminate\Validation\Rules\Password;
use App\Actions\Invitations\AcceptInvitation;
use Illuminate\Validation\ValidationException;
use App\Exceptions\InvitationNoLongerPendingException;

class InvitationAcceptController extends Controller
{
    public function show(string $token): Response|RedirectResponse
    {
        $invitation = $this->pendingInvitation($token);

        if (! $invitation) {
            return redirect()->route('login')->with('error', __('This invitation is no longer valid.'));
        }

        return Inertia::render('Auth/AcceptInvitation', [
            'token' => $token,
            'email' => $invitation->email,
            'inviter' => $invitation->inviter->name,
            'socialLogin' => collect(['google', 'github', 'discord'])
                ->filter(fn (string $provider): bool => (bool) config("services.$provider.client_id"))
                ->values(),
        ]);
    }

    public function store(Request $request, string $token, AcceptInvitation $acceptInvitation): RedirectResponse
    {
        $invitation = $this->pendingInvitation($token);

        if (! $invitation) {
            return redirect()->route('login')->with('error', __('This invitation is no longer valid.'));
        }

        $attributes = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', Password::default(), 'confirmed'],
        ]);

        // An invitation addressed to somebody cannot be redeemed by a different
        // address, otherwise a forwarded link would let anyone in under a name
        // the inviter never chose.
        if ($invitation->email !== null && ! hash_equals($invitation->email, $attributes['email'])) {
            throw ValidationException::withMessages([
                'email' => __('This invitation was sent to a different address.'),
            ]);
        }

        try {
            $user = $acceptInvitation($invitation, [
                'name' => $attributes['name'],
                'email' => $attributes['email'],
                'password' => Hash::make($attributes['password']),
            ], emailIsTrusted: false);
        } catch (InvitationNoLongerPendingException $exception) {
            return redirect()->route('login')->with('error', $exception->getMessage());
        }

        Auth::login($user);

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * The table stores a hash, so the lookup has to hash the incoming token
     * rather than compare it. Anything not pending is treated as absent, which
     * keeps revoked, expired and already accepted links indistinguishable.
     */
    private function pendingInvitation(string $token): ?Invitation
    {
        return Invitation::with('inviter')
            ->where('token', Invitation::hashToken($token))
            ->pending()
            ->first();
    }
}
