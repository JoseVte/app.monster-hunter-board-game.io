<?php

namespace App\Http\Controllers\Wiki;

use Inertia\Inertia;
use App\Models\Armor;
use Inertia\Response;
use App\Models\Hunter;
use Illuminate\Http\Request;
use App\Enum\MonsterExpansion;
use Illuminate\Support\Collection;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;

class ArmorController extends Controller
{
    /**
     * Grouped by the monster the set comes from, the way the hunter sheet lines
     * them up, so a row reads as one set across the three slots.
     */
    public function index(Request $request): Response
    {
        $filters = $this->filters($request);

        $armors = Armor::with('skills')
            ->whereNameLike($filters['q'])
            ->when($filters['rarity'], fn (Builder $q, int $rarity) => $q->where('rarity', $rarity))
            ->when($filters['expansion'], fn (Builder $q, string $expansion) => $q->where('expansion', $expansion))
            ->get()
            ->groupBy('branch')
            ->map(fn (Collection $pieces, string $branch): array => [
                'branch' => $branch,
                'pieces' => $pieces->keyBy('type_value'),
            ])
            ->values();

        return Inertia::render('Wiki/Armor/Index', [
            'branches' => $armors,
            'filters' => $filters,
            'options' => [
                'rarities' => Armor::query()->distinct()->orderBy('rarity')->pluck('rarity')->all(),
                'expansions' => MonsterExpansion::asKeyLabelObjectSelectable(),
            ],
        ]);
    }

    /**
     * One piece, printed as its card.
     */
    public function detail(Armor $armor): Response
    {
        $armor->load(['skills', 'items']);

        return Inertia::render('Wiki/Armor/Detail', [
            'armor' => $armor,
            'hunters' => $this->hunters(fn (Hunter $hunter): array => [
                'can_craft' => $hunter->canCraftArmor($armor),
                'missing' => $hunter->missingItems($armor->items),
                'owned' => $hunter->armors->contains($armor->id),
            ]),
        ]);
    }

    /**
     * The hunters that are the reader's own, each saying whether it can pay for
     * this. Being in a campaign is not the same as owning every hunter in it, so
     * these come through the membership rather than the campaign.
     *
     * @return Collection<int, array<string, mixed>>
     */
    private function hunters(callable $afford): Collection
    {
        return auth()->user()
            ?->hunters()
            ->with(['campaign', 'items', 'weapons', 'armors'])
            ->get()
            ->map(fn (Hunter $hunter): array => [
                ...$afford($hunter),
                'id' => $hunter->id,
                'name' => $hunter->name,
                'campaign' => $hunter->campaign->name,
                'campaign_id' => $hunter->campaign_id,
            ])
            ->values() ?? collect();
    }

    /**
     * @return array{q: ?string, rarity: ?int, expansion: ?string}
     */
    private function filters(Request $request): array
    {
        return [
            'q' => $request->string('q')->trim()->value() ?: null,
            'rarity' => $request->integer('rarity') ?: null,
            'expansion' => $request->string('expansion')->value() ?: null,
        ];
    }
}
