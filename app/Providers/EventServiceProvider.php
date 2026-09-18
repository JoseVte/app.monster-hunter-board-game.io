<?php

namespace App\Providers;

use App\Events\UserMonsterHunted;
use App\Events\UserEquipmentCrafted;
use Illuminate\Auth\Events\Registered;
use App\Listeners\UserLevelledUpListener;
use App\Listeners\UserMonsterHuntedListener;
use LevelUp\Experience\Events\UserLevelledUp;
use App\Listeners\UserEquipmentCraftedListener;
use SocialiteProviders\Manager\SocialiteWasCalled;
use SocialiteProviders\Discord\DiscordExtendSocialite;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        SocialiteWasCalled::class => [
            DiscordExtendSocialite::class.'@handle',
        ],
        UserEquipmentCrafted::class => [
            UserEquipmentCraftedListener::class,
        ],
        UserLevelledUp::class => [
            UserLevelledUpListener::class,
        ],
        UserMonsterHunted::class => [
            UserMonsterHuntedListener::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void {}

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
