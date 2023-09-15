<?php

namespace App\Http\Controllers;

use Arr;
use App\Models\Item;
use Inertia\Inertia;
use App\Models\Armor;
use App\Models\Weapon;
use App\Models\Monster;
use App\Models\ArmorSkill;
use App\Models\WeaponType;
use App\Models\WeaponAttack;
use Illuminate\Http\Request;
use App\Models\DowntimeActivity;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;

class SearchController extends Controller
{
    public function search(Request $request): \Inertia\Response
    {
        $results = $this->performanceSearch($request->query('query'), 100)->groupBy('class');

        return Inertia::render('Search', [
            'results' => $results,
            'query' => $request->query('query'),
        ]);
    }

    public function globalSearch(Request $request): JsonResponse
    {
        $results = $this->performanceSearch($request->get('keyword'));

        return response()->json($results);
    }

    private function performanceSearch(string $query = '', int $searchLimit = 5): Collection
    {
        $results = collect();
        if ($query) {
            $locale = app()->getLocale();
            $searchOptions = static function ($meiliSearch, string $query, array $options) {
                $options['attributesToHighlight'] = ['*'];
                $options['attributesToRetrieve'] = ['id', 'en', 'es'];

                $meiliSearch->updateSettings([
                    'searchableAttributes' => ['en', 'es'],
                ]);

                return $meiliSearch->search($query, $options);
            };
            $resultsMap = static function ($result, $class) use ($locale) {
                arr_expand($result['_formatted']);

                return [
                    'id' => $result['id'],
                    'class' => $class,
                    'classType' => Arr::get($result, '_formatted.type'),
                    'url' => Arr::get($result, '_formatted.url'),
                    'name' => Arr::get($result, '_formatted.'.$locale.'.name'),
                    'type' => Arr::get($result, '_formatted.'.$locale.'.type'),
                ];
            };

            foreach ([
                Armor::class,
                ArmorSkill::class,
                DowntimeActivity::class,
                Item::class,
                Monster::class,
                Weapon::class,
                WeaponType::class,
                WeaponAttack::class,
            ] as $class) {
                $results = $results->merge(collect(Arr::get(call_user_func([$class, 'search'], $query, $searchOptions)->take($searchLimit)->raw(), 'hits', []))
                    ->map(fn ($result) => $resultsMap($result, $class)));
            }
        }

        return $results;
    }
}
