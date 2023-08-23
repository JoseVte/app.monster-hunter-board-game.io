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
            'recaptcha_site_key' => config('services.google-recaptcha.site-key'),

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
            'user.campaigns' => $user->campaigns ?? [],
            'user.roles' => $user ? $user->roles->pluck('name') : [],
            'user.permissions' => $user ? $user->getPermissionsViaRoles()->pluck('name') : [],

            // Enums
            'dayType' => DayType::asKeyLabelObjectSelectable(),
            'monsterDifficulty' => MonsterDifficulty::asKeyLabelObjectSelectable(),

            'jetstreamAcceptText' => __('I agree to the :terms_of_service and :privacy_policy', [
                'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">'.__('Terms of Service').'</a>',
                'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">'.__('Privacy Policy').'</a>',
            ])
        ]);
    }
}
