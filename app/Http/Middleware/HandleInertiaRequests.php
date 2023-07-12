<?php

namespace App\Http\Middleware;

use App\Enum\DayType;
use Inertia\Middleware;
use Tightenco\Ziggy\Ziggy;
use Illuminate\Http\Request;
use App\Enum\MonsterDifficulty;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): string|null
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        $campaign = $request->route('campaign');
        $user = $request->user();

        return array_merge(parent::share($request), [
            'current_campaign' => $campaign ?? null,
            'current_campaign_id' => $campaign->id ?? null,
            'has_campaign_hunter' => $user ? $user->hasCampaignHunter($campaign) : false,

            'ziggy' => function () use ($request) {
                return array_merge((new Ziggy())->toArray(), [
                    'location' => $request->url(),
                    'query' => $request->query(),
                ]);
            },
            'locale' => app()->getLocale(),
            'user.roles' => $user ? $user->roles->pluck('name') : [],
            'user.permissions' => $user ? $user->getPermissionsViaRoles()->pluck('name') : [],

            // Enums
            'dayType' => DayType::asKeyLabelObjectSelectable(),
            'monsterDifficulty' => MonsterDifficulty::asKeyLabelObjectSelectable(),
        ]);
    }
}
