<?php

namespace App\Http\Controllers\Wiki;

use Inertia\Inertia;
use Inertia\Response;
use App\Models\Hunter;
use App\Models\Weapon;
use App\Models\WeaponType;
use App\Models\WeaponRecipe;
use Illuminate\Http\Request;
use App\Enum\MonsterExpansion;
use Illuminate\Support\Collection;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;

class WeaponController extends Controller
{
    /**
     * The fourteen types, each carrying how many of its weapons match the
     * filters, so a type with nothing to show says so before it is opened.
     */
    public function index(Request $request): Response
    {
        $filters = $this->filters($request);

        $types = WeaponType::query()
            ->withCount(['weapons' => fn (Builder $query) => $this->apply($query, $filters)])
            ->get();

        return Inertia::render('Wiki/Weapon/Index', [
            'weaponTypes' => $types,
            'filters' => $filters,
            'options' => $this->options(),
        ]);
    }

    /**
     * One type's tree. The filters mark which weapons match rather than pruning
     * the tree, since a line with a gap in it reads as a broken line.
     */
    public function show(Request $request, WeaponType $weaponType): Response
    {
        $filters = $this->filters($request);

        $matching = $this->apply(Weapon::where('type_id', $weaponType->id), $filters)->pluck('id');

        return Inertia::render('Wiki/Weapon/Show', [
            'weaponType' => $weaponType,
            'weapons' => create_weapon_tree($weaponType),
            'matching' => $matching,
            'filters' => $filters,
            'options' => $this->options(),
        ]);
    }

    /**
     * One weapon, printed as its card: what it does, what it costs and where it
     * sits in its line.
     */
    public function detail(Weapon $weapon): Response
    {
        $weapon->load(['type', 'parent', 'children', 'recipes.items', 'recipes.monster', 'attacksToAdd', 'attacksToRemove']);

        return Inertia::render('Wiki/Weapon/Detail', [
            'weapon' => $weapon,
            'hunters' => $this->hunters(fn (Hunter $hunter): array => [
                'craftable_recipes' => $hunter->craftableRecipes($weapon)->pluck('id'),
                'can_craft' => $hunter->canCraftWeapon($weapon),
                'missing_by_recipe' => $weapon->recipes->mapWithKeys(
                    fn (WeaponRecipe $recipe): array => [$recipe->id => $hunter->missingItems($recipe->items)],
                ),
                'owned' => $hunter->weapons->contains($weapon->id),
                'parent_owned' => $weapon->parent_id ? $hunter->weapons->contains($weapon->parent_id) : null,
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

    /**
     * @param  Builder<Weapon>  $query
     * @param  array{q: ?string, rarity: ?int, expansion: ?string}  $filters
     * @return Builder<Weapon>
     */
    private function apply(Builder $query, array $filters): Builder
    {
        return $query
            ->whereNameLike($filters['q'])
            ->when($filters['rarity'], fn (Builder $q, int $rarity) => $q->where('rarity', $rarity))
            ->when($filters['expansion'], fn (Builder $q, string $expansion) => $q->whereHas(
                'recipes',
                fn (Builder $recipes) => $recipes->where('expansion', $expansion),
            ));
    }

    /**
     * @return array{rarities: list<int>, expansions: list<array{key: string, label: string}>}
     */
    private function options(): array
    {
        return [
            'rarities' => Weapon::query()->distinct()->orderBy('rarity')->pluck('rarity')->all(),
            'expansions' => MonsterExpansion::asKeyLabelObjectSelectable(),
        ];
    }
}
