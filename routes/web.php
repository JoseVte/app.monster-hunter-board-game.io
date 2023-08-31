<?php

use App\Models\Item;
use App\Models\User;
use Inertia\Inertia;
use App\Models\Armor;
use App\Models\Weapon;
use App\Models\Monster;
use App\Enum\MonsterCategory;
use App\Enum\MonsterExpansion;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\CampaignHunterController;
use App\Http\Controllers\CampaignMemberController;
use App\Http\Controllers\CampaignHunterItemController;
use App\Http\Controllers\CampaignInvitationController;

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

Route::get('/', static function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
    ]);
})->name('welcome');

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
            Route::get('/', fn () => Inertia::render('Wiki/Monster/Index', [
                'filter' => [
                    'category' => MonsterCategory::asSelectable(),
                    'expansion' => MonsterExpansion::asSelectable(),
                ],
            ]))->name('index');

            Route::get('{monster}', fn (Monster $monster) => Inertia::render('Wiki/Monster/Show', compact('monster')))->name('show');
        });

        Route::prefix('items')->name('item.')->group(function (): void {
            Route::get('/', fn () => Inertia::render('Wiki/Item/Index'))->name('index');
            Route::get('{item}', fn (Item $item) => Inertia::render('Wiki/Item/Show', compact('item')))->name('show');
        });

        Route::prefix('armors')->name('armor.')->group(function (): void {
            Route::get('/', fn () => Inertia::render('Wiki/Armor/Index'))->name('index');
            Route::get('{armor}', fn (Armor $armor) => Inertia::render('Wiki/Armor/Show', compact('armor')))->name('show');
        });

        Route::prefix('weapons')->name('weapon.')->group(function (): void {
            Route::get('/', fn () => Inertia::render('Wiki/Weapon/Index'))->name('index');
            Route::get('{weapon}', fn (Weapon $weapon) => Inertia::render('Wiki/Weapon/Show', compact('weapon')))->name('show');
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

    Route::get('/campaign-invitations/{invitation}', [CampaignInvitationController::class, 'accept'])
        ->middleware(['signed'])
        ->name('campaign-invitations.accept');

    Route::delete('/campaign-invitations/{invitation}', [CampaignInvitationController::class, 'destroy'])
        ->name('campaign-invitations.destroy');

    Route::resource('campaigns.hunters', CampaignHunterController::class)->except('show');
    Route::get('campaigns/{campaign}/hunters/{hunter}/weapons/{weaponType}', [CampaignHunterController::class, 'showWeaponType'])
        ->name('campaigns.hunters.weapon-type.index');
    Route::post('campaigns/{campaign}/hunters/{hunter}/weapons/{weaponType}/{weapon}', [CampaignHunterController::class, 'craftWeapon'])
        ->name('campaigns.hunters.weapons.craft');
    Route::put('campaigns/{campaign}/hunters/{hunter}/weapons/{weaponType}/{weapon}', [CampaignHunterController::class, 'updateEquippedWeapon'])
        ->name('campaigns.hunters.weapons.equip');
    Route::post('campaigns/{campaign}/hunters/{hunter}/armors/{armor}', [CampaignHunterController::class, 'craftArmor'])
        ->name('campaigns.hunters.armors.craft');
    Route::put('campaigns/{campaign}/hunters/{hunter}/armors/{armor}', [CampaignHunterController::class, 'updateEquippedArmor'])
        ->name('campaigns.hunters.armors.equip');
    Route::get('campaigns/{campaign}/hunters/{hunter}/{tab?}/{weaponType?}', [CampaignHunterController::class, 'show'])
        ->name('campaigns.hunters.show')
        ->where('tab', 'items|weapons|armors');
    Route::put('campaigns/{campaign}/hunters/{hunter}/items/{item}/update-count', [CampaignHunterItemController::class, 'updateCount'])
        ->name('campaigns.hunters.items.update-count');
});
