<?php

namespace App\Providers;

use App\Models\Team;
use App\Models\Hunter;
use App\Models\Campaign;
use App\Models\Invitation;
use App\Policies\TeamPolicy;
use App\Policies\HunterPolicy;
use App\Policies\CampaignPolicy;
use App\Policies\InvitationPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Team::class => TeamPolicy::class,
        Campaign::class => CampaignPolicy::class,
        Hunter::class => HunterPolicy::class,
        Invitation::class => InvitationPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
    }
}
