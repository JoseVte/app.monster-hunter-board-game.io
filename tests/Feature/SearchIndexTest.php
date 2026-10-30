<?php

use App\Models\Item;
use App\Models\User;
use App\Models\Armor;
use App\Enum\ItemType;
use App\Models\Weapon;
use App\Models\Monster;
use App\Models\ArmorSkill;
use Laravel\Scout\Builder;
use App\Models\WeaponAttack;
use App\Models\DowntimeActivity;
use Laravel\Scout\EngineManager;
use Laravel\Scout\Engines\Engine;
use Illuminate\Support\Collection;
use Inertia\Testing\AssertableInertia;

// The search box talks to Meilisearch, which the suite does not run. Every
// model writes its document with flat, dotted keys (`en.name`, `es.type`),
// Meilisearch hands them back the same way under `_formatted` with the match
// wrapped in <em>, and `SearchController` expands those keys with
// `arr_expand()` before picking the current locale out of them. This engine
// stands in for Meilisearch at exactly that boundary: it builds each hit from
// the model's own `toSearchableArray()` and calls the controller's callback
// with an index that records what it was asked, the way Scout's Meilisearch
// engine does. Nothing else about the real service is imitated.

final class RecordingSearchIndex
{
    public array $settings = [];

    public array $searches = [];

    public function __construct(private readonly Collection $documents) {}

    public function updateSettings(array $settings): void
    {
        $this->settings[] = $settings;
    }

    public function search(string $query, array $options): array
    {
        $this->searches[] = ['query' => $query, 'options' => $options];

        $hits = $this->documents
            ->filter(fn (array $document): bool => collect($document)
                ->contains(fn (mixed $value): bool => is_string($value) && str_contains(mb_strtolower($value), mb_strtolower($query))))
            ->take($options['limit'] ?? 20)
            ->map(fn (array $document): array => [
                ...$document,
                '_formatted' => array_map(
                    fn (mixed $value): mixed => is_string($value)
                        ? preg_replace('/('.preg_quote($query, '/').')/i', '<em>$1</em>', $value)
                        : $value,
                    $document,
                ),
            ])
            ->values()
            ->all();

        return ['hits' => $hits];
    }
}

final class CallbackOnlySearchEngine extends Engine
{
    /** @var array<class-string, RecordingSearchIndex> */
    public array $indexes = [];

    public function search(Builder $builder)
    {
        $model = $builder->model;
        $index = $this->indexes[$model::class] ??= new RecordingSearchIndex(
            $model->newQuery()->get()->map(fn ($record): array => ['id' => $record->getKey(), ...$record->toSearchableArray()]),
        );

        return call_user_func($builder->callback, $index, $builder->query, ['limit' => $builder->limit]);
    }

    public function update($models): void {}

    public function delete($models): void {}

    public function paginate(Builder $builder, $perPage, $page): void {}

    public function mapIds($results): Collection
    {
        return collect();
    }

    public function map(Builder $builder, $results, $model): Collection
    {
        return collect();
    }

    public function lazyMap(Builder $builder, $results, $model): void {}

    public function getTotalCount($results): int
    {
        return 0;
    }

    public function flush($model): void {}

    public function createIndex($name, array $options = []): void {}

    public function deleteIndex($name): void {}
}

beforeEach(function (): void {
    $engine = $this->engine = new CallbackOnlySearchEngine;
    // The manager binds the creator to itself, so the engine is captured
    // rather than read from the test case.
    app(EngineManager::class)->extend('recording', fn () => $engine);
    config(['scout.driver' => 'recording']);

    $this->actingAs(User::factory()->withPersonalTeam()->create());

    $this->monster = Monster::factory()->create(['name' => ['en' => 'Rathalos', 'es' => 'Rathalos ES']]);
    $this->item = Item::factory()->create(['name' => ['en' => 'Rathalos Scale', 'es' => 'Escama de Rathalos'], 'type' => ItemType::MONSTER_PART->name]);
    $this->armor = Armor::factory()->create(['name' => ['en' => 'Rathalos Helm', 'es' => 'Yelmo Rathalos']]);
    $this->skill = ArmorSkill::create(['name' => ['en' => 'Rathalos Mastery', 'es' => 'Maestria Rathalos'], 'description' => ['en' => '-', 'es' => '-']]);
    $this->armor->skills()->attach($this->skill);
    $this->weapon = Weapon::factory()->create(['name' => ['en' => 'Rathalos Glinsword', 'es' => 'Espada Rathalos']]);
    $this->activity = DowntimeActivity::create(['name' => ['en' => 'Rest', 'es' => 'Descanso'], 'description' => ['en' => '-', 'es' => '-']]);
    $this->attack = WeaponAttack::create(['name' => ['en' => 'Slash', 'es' => 'Tajo'], 'description' => ['en' => '-', 'es' => '-']]);
    Monster::factory()->create(['name' => ['en' => 'Anjanath', 'es' => 'Anjanath']]);
});

test('the global search answers from every model, with the link and the highlighted name in the reader\'s language', function (): void {
    $results = collect($this->getJson(route('global-search', ['keyword' => 'rathalos']))
        ->assertOk()
        ->json())
        ->keyBy('class');

    expect($results->keys()->sort()->values()->all())->toBe([
        Armor::class,
        ArmorSkill::class,
        Item::class,
        Monster::class,
        Weapon::class,
    ]);

    expect($results[Monster::class])->toMatchArray([
        'id' => $this->monster->id,
        'url' => route('wiki.monster.show', $this->monster->id),
        'name' => '<em>Rathalos</em>',
    ])
        ->and($results[Item::class])->toMatchArray([
            'url' => route('wiki.item.show', $this->item->id),
            'classType' => 'monster_part',
            'name' => '<em>Rathalos</em> Scale',
            'type' => ItemType::MONSTER_PART->label('en'),
        ])
        ->and($results[Armor::class]['url'])->toBe(route('wiki.armor.show', $this->armor->id))
        ->and($results[Weapon::class]['url'])->toBe(route('wiki.weapon.show', $this->weapon->id))
        ->and($results[ArmorSkill::class])->toMatchArray(['url' => null, 'name' => '<em>Rathalos</em> Mastery']);
});

test('a Spanish reader gets the Spanish name of what matched', function (): void {
    $results = collect($this->withSession(['locale' => 'es'])
        ->getJson(route('global-search', ['keyword' => 'escama']))
        ->assertOk()
        ->json());

    expect($results)->toHaveCount(1)
        ->and($results->first())->toMatchArray([
            'class' => Item::class,
            'name' => '<em>Escama</em> de Rathalos',
            'type' => ItemType::MONSTER_PART->label('es'),
        ]);
});

test('an armour is found by the name of its skill', function (): void {
    $results = collect($this->getJson(route('global-search', ['keyword' => 'mastery']))->json());

    expect($results->pluck('class')->all())->toContain(Armor::class, ArmorSkill::class);
});

test('the dropdown keeps five hits per kind and the results page a hundred', function (): void {
    Monster::factory()->count(6)->sequence(fn ($sequence): array => [
        'name' => ['en' => "Rathian {$sequence->index}", 'es' => "Rathian {$sequence->index}"],
    ])->create();

    $dropdown = collect($this->getJson(route('global-search', ['keyword' => 'rathian']))->json());
    expect($dropdown)->toHaveCount(5);

    $this->get(route('search', ['query' => 'rathian']))
        ->assertInertia(
            fn (AssertableInertia $page) => $page
                ->component('Search')
                ->where('results', fn (Collection $results): bool => count($results[Monster::class]) === 6)
        );

    expect($this->engine->indexes[Monster::class]->searches)->sequence(
        fn ($search) => $search->options->limit->toBe(5),
        fn ($search) => $search->options->limit->toBe(100),
    );
});

test('the results page groups the hits by kind', function (): void {
    $this->get(route('search', ['query' => 'rathalos']))
        ->assertOk()
        ->assertInertia(
            fn (AssertableInertia $page) => $page
                ->component('Search')
                ->where('query', 'rathalos')
                ->has('results', 5)
        );
});

test('the index is asked to search both languages and highlight every field', function (): void {
    $this->getJson(route('global-search', ['keyword' => 'slash']))->assertOk();

    $index = $this->engine->indexes[WeaponAttack::class];

    expect($index->settings)->toBe([['searchableAttributes' => ['en', 'es']]])
        ->and($index->searches[0]['query'])->toBe('slash')
        ->and($index->searches[0]['options'])->toMatchArray([
            'attributesToHighlight' => ['*'],
            'attributesToRetrieve' => ['id', 'en', 'es'],
        ]);
});

test('nothing is asked of the index without a query', function (): void {
    $this->getJson(route('global-search'))->assertExactJson([]);
    $this->get(route('search'))->assertOk();

    expect($this->engine->indexes)->toBe([]);
});

test('arr_expand turns dotted keys into nested arrays at any depth', function (): void {
    $document = [
        'url' => '/wiki/armors/1',
        'en.name' => 'Rathalos Helm',
        'en.0.skill' => 'Rathalos Mastery',
        'es.name' => 'Yelmo Rathalos',
    ];

    arr_expand($document);

    expect($document)->toBe([
        'url' => '/wiki/armors/1',
        'en' => ['name' => 'Rathalos Helm', 0 => ['skill' => 'Rathalos Mastery']],
        'es' => ['name' => 'Yelmo Rathalos'],
    ]);
});

test('arr_expand leaves anything that is not an array alone', function (): void {
    $value = 'en.name';

    arr_expand($value);

    expect($value)->toBe('en.name');
});

test('an emptied search box answers with nothing rather than an error', function (): void {
    $this->getJson(route('global-search', ['keyword' => '']))->assertExactJson([]);
    $this->get(route('search', ['query' => '']))->assertOk();
});
