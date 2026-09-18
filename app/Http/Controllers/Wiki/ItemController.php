<?php

namespace App\Http\Controllers\Wiki;

use App\Models\Item;
use Inertia\Inertia;
use Inertia\Response;
use App\Enum\ItemType;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;

class ItemController extends Controller
{
    /**
     * Every item, flat: there is no rarity or expansion to group them by, only
     * a name and a type. Sorted by type before name by default, common to
     * monster part the way the enum itself declares them.
     *
     * Sorted in PHP rather than SQL: MySQL compares a bare `json_extract()`
     * result as a JSON value, not as text, and coercing it first with `lower`
     * or `cast(... as char)` reorders names that are a prefix of one another
     * ("Ala de Rathalos" landed after "Ala de Rathalos Celeste"). The list is
     * never paginated, so sorting what already came back costs nothing extra
     * and sidesteps a divergence sqlite, lacking `json_unquote`, cannot even
     * be made to agree with MySQL on.
     */
    public function index(Request $request): Response
    {
        $filters = $this->filters($request);

        $items = Item::query()
            ->whereNameLike($filters['q'])
            ->when($filters['type'], fn (Builder $q, string $type) => $q->where('type', $type))
            ->get();

        return Inertia::render('Wiki/Item/Index', [
            'items' => $this->sort($items, $filters['sort'], $filters['direction']),
            'filters' => $filters,
            'options' => [
                'types' => ItemType::asKeyLabelObjectSelectable(),
            ],
        ]);
    }

    /**
     * @param  Collection<int, Item>  $items
     * @return Collection<int, Item>
     */
    private function sort(Collection $items, string $sort, string $direction): Collection
    {
        $typePosition = collect(ItemType::cases())->pluck('name')->flip();

        $sorted = $items->sort(function (Item $a, Item $b) use ($sort, $typePosition): int {
            if ($sort === 'type') {
                $byType = $typePosition[$a->type->name] <=> $typePosition[$b->type->name];

                if ($byType !== 0) {
                    return $byType;
                }
            }

            return mb_strtolower($a->name) <=> mb_strtolower($b->name);
        })->values();

        return $direction === 'desc' ? $sorted->reverse()->values() : $sorted;
    }

    /**
     * One item: where it comes from and what it is spent on.
     */
    public function detail(Item $item): Response
    {
        $item->load(['monsters', 'weapons.type', 'armors']);

        return Inertia::render('Wiki/Item/Show', [
            'item' => $item,
        ]);
    }

    /**
     * `sort` and `direction` are whitelisted rather than merely defaulted, so
     * the comparator in `sort()` only ever has to branch on values it knows.
     *
     * @return array{q: ?string, type: ?string, sort: string, direction: string}
     */
    private function filters(Request $request): array
    {
        return [
            'q' => $request->string('q')->trim()->value() ?: null,
            'type' => $request->string('type')->value() ?: null,
            'sort' => $request->string('sort')->value() === 'name' ? 'name' : 'type',
            'direction' => $request->string('direction')->value() === 'desc' ? 'desc' : 'asc',
        ];
    }
}
