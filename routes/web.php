<?php

use App\Models\Item;
use Inertia\Inertia;
use App\Models\Armor;
use App\Models\Weapon;
use App\Models\Monster;
use App\Models\WeaponType;
use App\Models\ArmorAbility;
use App\Models\WeaponAttack;
use App\Enum\MonsterCategory;
use App\Enum\MonsterExpansion;
use App\Models\DowntimeActivity;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\CampaignController;

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

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function (): void {
    Route::get('/dashboard', function () {
        /** @var \App\Models\User $user */
        $user = auth()->user();
        $campaigns = $user->campaigns()
            ->with(['team', 'team.owner'])
            ->withCount('days')
            ->orderBy('updated_at', 'desc')
            ->get();

        return Inertia::render('Dashboard', compact('campaigns'));
    })->name('dashboard');

    Route::get('global-search', static function (Illuminate\Http\Request $request): JsonResponse {
        $locale = app()->getLocale();
        $searchOptions = static function ($meiliSearch, string $query, array $options) use ($locale) {
            $options['attributesToHighlight'] = ['*'];
            $options['attributesToRetrieve'] = ['id', $locale];

            $meiliSearch->updateSettings([
                'searchableAttributes' => [$locale],
            ]);

            return $meiliSearch->search($query, $options);
        };
        $searchLimit = 5;
        $resultsMap = static function ($result, $class) use ($locale) {
            arr_expand($result['_formatted']);

            return [
                'id' => $result['id'],
                'class' => $class,
                'url' => Arr::get($result, '_formatted.url'),
                'name' => Arr::get($result, '_formatted.'.$locale.'.name'),
                'type' => Arr::get($result, '_formatted.'.$locale.'.type'),
            ];
        };

        $results = collect();
        foreach ([Armor::class, ArmorAbility::class, DowntimeActivity::class, Item::class, Monster::class, Weapon::class, WeaponType::class, WeaponAttack::class] as $class) {
            $results = $results->merge(collect(Arr::get(call_user_func([$class, 'search'], $request->get('keyword'), $searchOptions)->take($searchLimit)->raw(), 'hits', []))
                ->map(fn ($result) => $resultsMap($result, $class)));
        }

        return response()->json($results);
    })->name('global-search');

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
        });

        Route::prefix('armors')->name('armor.')->group(function (): void {
            Route::get('/', fn () => Inertia::render('Wiki/Armor/Index'))->name('index');
        });

        Route::prefix('weapons')->name('weapon.')->group(function (): void {
            Route::get('/', fn () => Inertia::render('Wiki/Weapon/Index'))->name('index');
        });
    });

    Route::resource('campaigns', CampaignController::class);
    Route::put('campaigns/{campaign}/update-potions', [CampaignController::class, 'updatePotions'])->name('campaigns.update-potions');
});
