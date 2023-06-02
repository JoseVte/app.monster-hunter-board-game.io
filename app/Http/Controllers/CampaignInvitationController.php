<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CampaignInvitation;
use Illuminate\Support\Facades\Gate;
use App\Actions\Jetstream\AddCampaignMember;
use Illuminate\Auth\Access\AuthorizationException;

class CampaignInvitationController extends Controller
{
    public function accept(Request $request, $invitationId)
    {
        $invitation = CampaignInvitation::whereKey($invitationId)->firstOrFail();

        app(AddCampaignMember::class)->add(
            $invitation->campaign->team->owner,
            $invitation->campaign,
            $invitation->email,
            $invitation->role->name
        );

        $invitation->delete();

        return redirect(config('fortify.home'))->banner(
            __('Great! You have accepted the invitation to join the :campaign campaign.', ['campaign' => $invitation->campaign->name]),
        );
    }

    public function destroy(Request $request, $invitationId)
    {
        $invitation = CampaignInvitation::whereKey($invitationId)->firstOrFail();

        if (!Gate::forUser($request->user())->check('removeCampaignMember', $invitation->campaign)) {
            throw new AuthorizationException();
        }

        $invitation->delete();

        return back(303);
    }
}
