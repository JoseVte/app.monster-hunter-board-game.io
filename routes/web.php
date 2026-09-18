<?php

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\ProfileLevelController;
use App\Http\Controllers\CampaignHunterController;
use App\Http\Controllers\CampaignMemberController;
use App\Http\Controllers\Auth\SocialAuthController;
use App\Http\Controllers\CampaignHunterItemController;
use App\Http\Controllers\CampaignInvitationController;
use App\Http\Controllers\Auth\InvitationAcceptController;
use App\Http\Controllers\Wiki\ItemController as WikiItemController;
use App\Http\Controllers\Wiki\ArmorController as WikiArmorController;
use App\Http\Controllers\Wiki\WeaponController as WikiWeaponController;
use App\Http\Controllers\Wiki\MonsterController as WikiMonsterController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Local-only: logs straight in as the QA account (see UserSeeder/tinker
// note below) without going through the login form, whose recaptcha check
// a headless browser session can never reliably pass. Never registered
// outside `local`, so it cannot exist in a deployed environment.
if (app()->environment('local')) {
    Route::get('/__qa_login', static function () {
        $user = User::firstOrCreate(
            ['email' => 'claude@test.local'],
            [
                'name' => 'Claude QA',
                'password' => bcrypt('claude-qa-local'),
                'email_verified_at' => now(),
            ],
        );

        if (! $user->currentTeam) {
            $user->ownedTeams()->save(\App\Models\Team::forceCreate([
                'user_id' => $user->id,
                'name' => 'Claude QA\'s Team',
                'personal_team' => true,
            ]));
            $user->refresh()->switchTeam($user->ownedTeams()->first());
        }

        auth()->login($user);

        return redirect('/dashboard');
    })->name('qa-login');
}

Route::get('/', static fn () => Inertia::render('Welcome', [
    'canLogin' => Route::has('login'),
    'canRegister' => Route::has('register'),
]))->name('welcome');

Route::get('language/{language}', static function ($language) {
    session()->put('locale', $language);
    App::setLocale($language);

    return back(302, [], route('welcome'));
})->name('language');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function (): void {
    Route::get('/dashboard', function () {
        /** @var User $user */
        $user = auth()->user();
        $campaigns = $user->campaigns()
            ->with(['team', 'team.owner', 'users'])
            ->withCount('days')
            ->orderBy('updated_at', 'desc')
            ->get();

        return Inertia::render('Dashboard', compact('campaigns'));
    })->name('dashboard');

    Route::get('/search', [SearchController::class, 'search'])->name('search');
    Route::get('/global-search', [SearchController::class, 'globalSearch'])->name('global-search');

    Route::prefix('wiki')->name('wiki.')->group(function (): void {
        Route::get('/', fn () => Inertia::render('Wiki/Index'))->name('index');

        Route::prefix('monsters')->name('monster.')->group(function (): void {
            Route::get('/', [WikiMonsterController::class, 'index'])->name('index');
            Route::get('{monster}', [WikiMonsterController::class, 'detail'])->name('show');
            Route::get('{monster}/card', [WikiMonsterController::class, 'card'])->name('card');
        });

        Route::prefix('items')->name('item.')->group(function (): void {
            Route::get('/', [WikiItemController::class, 'index'])->name('index');
            Route::get('{item}', [WikiItemController::class, 'detail'])->name('show');
        });

        Route::prefix('armors')->name('armor.')->group(function (): void {
            Route::get('/', [WikiArmorController::class, 'index'])->name('index');
            Route::get('{armor}', [WikiArmorController::class, 'detail'])->name('show');
        });

        Route::prefix('weapons')->name('weapon.')->group(function (): void {
            Route::get('/', [WikiWeaponController::class, 'index'])->name('index');
            Route::get('type/{weaponType}', [WikiWeaponController::class, 'show'])->name('type');
            Route::get('{weapon}', [WikiWeaponController::class, 'detail'])->name('show');
        });
    });

    Route::resource('campaigns', CampaignController::class);
    Route::put('campaigns/{campaign}/update-potions', [CampaignController::class, 'updatePotions'])
        ->name('campaigns.update-potions');
    Route::put('campaigns/{campaign}/add-day', [CampaignController::class, 'addDay'])
        ->name('campaigns.add-day');
    Route::put('campaigns/{campaign}/update-day/{day}', [CampaignController::class, 'updateDay'])
        ->name('campaigns.update-day');
    Route::post('campaigns/{campaign}/members', [CampaignMemberController::class, 'store'])
        ->name('campaign-members.store');
    Route::put('campaigns/{campaign}/members/{user}', [CampaignMemberController::class, 'update'])
        ->name('campaign-members.update');
    Route::delete('campaigns/{campaign}/members/{user}', [CampaignMemberController::class, 'destroy'])
        ->name('campaign-members.destroy');

    Route::delete('/campaign-invitations/{invitation}', [CampaignInvitationController::class, 'destroy'])
        ->name('campaign-invitations.destroy');

    Route::resource('campaigns.hunters', CampaignHunterController::class)->except('show')->scoped(['campaign', 'hunter']);
    Route::get('campaigns/{campaign}/hunters/{hunter}/weapons/{weaponType}', [CampaignHunterController::class, 'showWeaponType'])
        ->name('campaigns.hunters.weapon-type.index');
    Route::post('campaigns/{campaign}/hunters/{hunter}/weapons/{weaponType}/{weapon}', [CampaignHunterController::class, 'craftWeapon'])
        ->name('campaigns.hunters.weapons.craft');
    Route::put('campaigns/{campaign}/hunters/{hunter}/weapons/{weaponType}/{weapon}', [CampaignHunterController::class, 'updateEquippedWeapon'])
        ->name('campaigns.hunters.weapons.equip');
    Route::put('campaigns/{campaign}/hunters/{hunter}/hunt-with/{weaponType}', [CampaignHunterController::class, 'updateHuntingWeaponType'])
        ->name('campaigns.hunters.weapon-type.hunt');
    Route::post('campaigns/{campaign}/hunters/{hunter}/armors/{armor}', [CampaignHunterController::class, 'craftArmor'])
        ->name('campaigns.hunters.armors.craft');
    Route::put('campaigns/{campaign}/hunters/{hunter}/armors/{armor}', [CampaignHunterController::class, 'updateEquippedArmor'])
        ->name('campaigns.hunters.armors.equip');
    Route::get('campaigns/{campaign}/hunters/{hunter}/{tab?}/{weaponType?}', [CampaignHunterController::class, 'show'])
        ->name('campaigns.hunters.show')
        ->where('tab', 'items|weapons|armors');
    Route::put('campaigns/{campaign}/hunters/{hunter}/items', [CampaignHunterItemController::class, 'storeMany'])
        ->name('campaigns.hunters.items.store-many');
    Route::put('campaigns/{campaign}/hunters/{hunter}/items/{item}/update-count', [CampaignHunterItemController::class, 'updateCount'])
        ->name('campaigns.hunters.items.update-count');

    Route::get('user/level', [ProfileLevelController::class, 'index'])
        ->name('profile.level');
});

Route::get('auth/{provider}', [SocialAuthController::class, 'redirect'])
    ->whereIn('provider', ['google', 'github', 'discord'])
    ->name('auth.social.redirect');
Route::get('auth/{provider}/callback', [SocialAuthController::class, 'callback'])
    ->whereIn('provider', ['google', 'github', 'discord'])
    ->name('auth.social.callback');

Route::middleware(['auth:sanctum', 'verified'])->group(function (): void {
    Route::post('invitations', [InvitationController::class, 'store'])
        ->middleware('throttle:invitations')
        ->name('invitations.store');
    Route::put('invitations/{invitation}', [InvitationController::class, 'update'])
        ->middleware('throttle:invitations')
        ->whereNumber('invitation')
        ->name('invitations.resend');
    Route::delete('invitations/{invitation}', [InvitationController::class, 'destroy'])
        ->whereNumber('invitation')
        ->name('invitations.destroy');

    Route::get('profile/social/{provider}', [SocialAuthController::class, 'redirectFromProfile'])
        ->whereIn('provider', ['google', 'github', 'discord'])
        ->name('profile.social.redirect');
    Route::delete('profile/social/{provider}', [SocialAuthController::class, 'unlink'])
        ->whereIn('provider', ['google', 'github', 'discord'])
        ->name('profile.social.unlink');
});

// Declared after Jetstream's own route so this one wins: it renders the same
// page with the invitations the profile needs.
Route::get('user/profile', [ProfileController::class, 'show'])
    ->middleware(['auth:sanctum', 'verified'])
    ->name('profile.show');

// Accepting sits outside the auth group on purpose: the invitation may be the
// first the person has ever heard of the platform, so a login wall would be a
// dead end. The signature is what proves the link came from us.
Route::get('/campaign-invitations/{invitation}', [CampaignInvitationController::class, 'accept'])
    ->middleware(['signed'])
    ->name('campaign-invitations.accept');
Route::post('/campaign-invitations/{invitation}', [CampaignInvitationController::class, 'acceptAsNewUser'])
    ->middleware(['signed'])
    ->name('campaign-invitations.register');

Route::get('invite/{token}', [InvitationAcceptController::class, 'show'])->name('invitations.show');
Route::post('invite/{token}', [InvitationAcceptController::class, 'store'])->name('invitations.accept');
