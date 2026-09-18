<?php

namespace App\Http\Controllers\Wiki;

use Inertia\Inertia;
use Inertia\Response;
use App\Models\Monster;
use Illuminate\Http\Request;
use App\Enum\MonsterCategory;
use App\Enum\MonsterExpansion;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;

class MonsterController extends Controller
{
    /**
     * Every monster, flat: fifteen of them, so there is nothing here for a
     * page to cut into.
     */
    public function index(Request $request): Response
    {
        $filters = $this->filters($request);

        $monsters = Monster::query()
            ->select(['id', 'name', 'category', 'expansion', 'icon_path'])
            ->whereNameLike($filters['q'])
            ->when($filters['category'], fn (Builder $q, string $category) => $q->where('category', $category))
            ->when($filters['expansion'], fn (Builder $q, string $expansion) => $q->where('expansion', $expansion))
            ->get();

        return Inertia::render('Wiki/Monster/Index', [
            'monsters' => $monsters,
            'filters' => $filters,
            'options' => [
                'categories' => MonsterCategory::asKeyLabelObjectSelectable(),
                'expansions' => MonsterExpansion::asKeyLabelObjectSelectable(),
            ],
        ]);
    }

    /**
     * One monster, printed as its card.
     */
    public function detail(Monster $monster): Response
    {
        $monster->load(['difficulties.parts', 'rewards.item']);

        return Inertia::render('Wiki/Monster/Show', [
            'monster' => $monster,
        ]);
    }

    /**
     * The same monster recreated as its physical card: resistances, body
     * parts and the ability of whichever difficulty tier the reader picks.
     */
    public function card(Monster $monster): Response
    {
        $monster->load('difficulties.parts');

        return Inertia::render('Wiki/Monster/Card', [
            'monster' => $monster,
        ]);
    }

    /**
     * @return array{q: ?string, category: ?string, expansion: ?string}
     */
    private function filters(Request $request): array
    {
        return [
            'q' => $request->string('q')->trim()->value() ?: null,
            'category' => $request->string('category')->value() ?: null,
            'expansion' => $request->string('expansion')->value() ?: null,
        ];
    }
}
