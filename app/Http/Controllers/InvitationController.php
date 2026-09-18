<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use App\Mail\UserInvitation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\RedirectResponse;
use App\Actions\Invitations\CreateInvitation;
use Illuminate\Validation\ValidationException;

class InvitationController extends Controller
{
    public function store(Request $request, CreateInvitation $createInvitation): RedirectResponse
    {
        $request->validate([
            'email' => ['nullable', 'email', 'unique:users,email'],
        ], [
            'email.unique' => __('That address already has an account.'),
        ]);

        $this->guardAgainstTooManyPending($request);

        ['invitation' => $invitation, 'token' => $token] = $createInvitation($request->user(), $request->input('email'));

        $this->deliver($invitation, $token);

        return back(303)->with('status', __('Invitation sent.'));
    }

    public function update(Request $request, Invitation $invitation, CreateInvitation $createInvitation): RedirectResponse
    {
        $this->authorize('update', $invitation);

        // The stored token is a hash, so resending cannot reuse it. The old row
        // is revoked and a fresh one takes its place, which also means a link
        // that has already been shared stops working.
        $invitation->forceFill(['revoked_at' => now()])->save();

        ['invitation' => $replacement, 'token' => $token] = $createInvitation($request->user(), $invitation->email);

        $this->deliver($replacement, $token);

        return back(303)->with('status', __('Invitation sent again.'));
    }

    public function destroy(Invitation $invitation): RedirectResponse
    {
        $this->authorize('update', $invitation);

        $invitation->forceFill(['revoked_at' => now()])->save();

        return back(303)->with('status', __('Invitation revoked.'));
    }

    private function deliver(Invitation $invitation, string $token): void
    {
        if ($invitation->email === null) {
            return;
        }

        Mail::to($invitation->email)->send(new UserInvitation($invitation, $token));
    }

    /**
     * @throws ValidationException
     */
    private function guardAgainstTooManyPending(Request $request): void
    {
        $pending = $request->user()->sentInvitations()->pending()->count();

        if ($pending < config('invitations.max_pending_per_user')) {
            return;
        }

        throw ValidationException::withMessages([
            'email' => __('You have reached your limit of :count pending invitations.', [
                'count' => config('invitations.max_pending_per_user'),
            ]),
        ]);
    }
}
