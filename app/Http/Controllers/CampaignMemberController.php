<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Campaign;
use Illuminate\Http\Request;
use Laravel\Jetstream\Features;
use Illuminate\Http\RedirectResponse;
use App\Actions\Jetstream\AddCampaignMember;
use App\Actions\Jetstream\InviteCampaignMember;
use App\Actions\Jetstream\RemoveCampaignMember;
use App\Actions\Jetstream\UpdateCampaignMemberRole;

class CampaignMemberController extends Controller
{
    public function store(Request $request, Campaign $campaign): RedirectResponse
    {
        if (Features::sendsTeamInvitations()) {
            app(InviteCampaignMember::class)->invite(
                $request->user(),
                $campaign,
                $request->email ?: '',
                $request->role
            );
        } else {
            app(AddCampaignMember::class)->add(
                $request->user(),
                $campaign,
                $request->email ?: '',
                $request->role
            );
        }

        return back(303);
    }

    public function update(Request $request, Campaign $campaign, $userId): RedirectResponse
    {
        app(UpdateCampaignMemberRole::class)->update(
            $request->user(),
            $campaign,
            $userId,
            $request->role
        );

        return back(303);
    }

    public function destroy(Request $request, Campaign $campaign, User $user): RedirectResponse
    {
        app(RemoveCampaignMember::class)->remove(
            $request->user(),
            $campaign,
            $user
        );

        if ($request->user()->id === $user->id) {
            return redirect(config('fortify.home'));
        }

        return back(303);
    }
}
