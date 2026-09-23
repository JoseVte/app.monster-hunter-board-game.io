<?php

use App\Models\Craft;
use App\Models\Monster;
use App\Models\Invitation;
use App\Models\WeaponType;
use App\Models\MonsterDifficulty;
use App\Support\TypeScript\ModelShape;
use Illuminate\Support\Facades\Schema;

test('a column becomes a property of its mapped type', function (): void {
    $shape = ModelShape::for(Monster::class);

    expect($shape['id']->type)->toBe('number')
        ->and($shape['id']->optional)->toBeFalse();
});

// Missing this is the single largest source of false confidence: most columns
// in this schema are nullable, and a type that omits null typechecks green
// against the exact access that throws at runtime.
test('a nullable column carries null in its type', function (): void {
    $shape = ModelShape::for(Monster::class);

    expect($shape['resistance_fire']->type)->toBe('number | null')
        ->and($shape['icon_path']->type)->toBe('string | null');
});

test('a column with no cast falls back to the schema type', function (): void {
    // icon_path is a varchar column with no cast on Monster, so the column type
    // decides. This covers the default arm of the match statement.
    $shape = ModelShape::for(Monster::class);

    expect($shape['icon_path']->type)->toBe('string | null');
});

// TypeScriptObject::write() returns the literal string `object` when it has no
// properties, so a model the generator quietly skipped is indistinguishable
// from one it handled. Craft has no casts and no translatable attributes,
// which is exactly the shape that would produce it.
test('a model with no casts and no translatables still emits every column', function (): void {
    $shape = ModelShape::for(Craft::class);

    expect(array_keys($shape))->toContain('id', 'user_id', 'craftable_type', 'created_at');
});

test('a missing table says to migrate rather than throwing a PDO error', function (): void {
    Schema::drop('crafts');

    expect(fn () => ModelShape::for(Craft::class))
        ->toThrow(RuntimeException::class, 'Run `php artisan migrate`');
});

// HasTranslations::toArray() flattens a translatable attribute to the current
// locale before Inertia sees it, so the JSON column arrives as a plain string.
test('a translatable column is a string, not the json it is stored as', function (): void {
    $shape = ModelShape::for(Monster::class);

    expect($shape['name']->type)->toBe('string')
        ->and($shape['description']->type)->toBe('string | null');
});

// The same toArray() replaces a cast using the TranslatableEnum trait with its
// translated label. Monster.category reaches the browser as "Large Monster",
// never as a MonsterCategory value.
test('a translatable enum cast is its label, not the enum', function (): void {
    $shape = ModelShape::for(Monster::class);

    expect($shape['category']->type)->toBe('string')
        ->and($shape['expansion']->type)->toBe('string');
});

test('a to-many relation is an optional array of the related type', function (): void {
    $shape = ModelShape::for(Monster::class);

    expect($shape['difficulties']->type)->toBe('Array<App.Models.MonsterDifficulty>')
        ->and($shape['difficulties']->optional)->toBeTrue();
});

test('a to-one relation is an optional single type', function (): void {
    $shape = ModelShape::for(MonsterDifficulty::class);

    expect($shape['monster']->type)->toBe('App.Models.Monster')
        ->and($shape['monster']->optional)->toBeTrue();
});

test('a relation method named in camelCase becomes its snake_case key', function (): void {
    // Eloquent serialises a loaded relation under the snake_cased method name.
    // Weapon::songList() and Weapon::attacksToAdd() are the two real examples.
    $shape = ModelShape::for(App\Models\Weapon::class);

    expect($shape)->toHaveKey('song_list')
        ->and($shape)->toHaveKey('attacks_to_add');
});

// WeaponController:29 sends weapon types through withCount, so this key really
// does arrive, and only sometimes.
test('every relation brings an optional count', function (): void {
    $shape = ModelShape::for(WeaponType::class);

    expect($shape['weapons_count']->type)->toBe('number')
        ->and($shape['weapons_count']->optional)->toBeTrue();
});

// A MorphTo built from an unsaved model reports the parent as its related
// class, so describing Craft::craftable() emitted `App.Models.Craft`: the
// model describing itself. Skipped rather than guessed, which leaves reading
// it a compile error instead of a silent lie.
test('a polymorphic relation is left undeclared rather than described wrongly', function (): void {
    $shape = ModelShape::for(Craft::class);

    expect($shape)->not->toHaveKey('craftable')
        ->and($shape)->not->toHaveKey('craftable_count')
        ->and($shape)->toHaveKey('user');
});

// Role and Permission live in spatie/laravel-permission, under vendor/, so the
// transformer's own transformDirectories(app_path()) never walks them and
// never emits App.Models.Role or App.Models.Permission on its own. Without
// the allow-list below this relation would name a type nobody declares.
test('a relation to an allow-listed vendor model is described normally', function (): void {
    $shape = ModelShape::for(App\Models\Pivot\CampaignMembership::class);

    expect($shape['role']->type)->toBe('App.Models.Role')
        ->and($shape['role']->optional)->toBeTrue();
});

// A relation to a class outside App\Models that nobody declared in
// resources/js/types/vendor-models.d.ts would otherwise name a type nobody
// ever writes, and skipLibCheck hides that as `any`, which is worse than the
// `unknown` this generator already refuses elsewhere. Refusing by name, the
// relation, and the class is what makes that loud instead of silent.
test('a relation to a class outside App\Models and off the vendor allow-list is refused', function (): void {
    expect(fn () => ModelShape::for(FixtureModelWithUnallowedVendorRelation::class))
        ->toThrow(RuntimeException::class, 'vendor-models.d.ts');
});

test('a class docblock @typescript overrides the derived type', function (): void {
    $shape = ModelShape::for(Invitation::class);

    expect($shape['status']->type)->toBe('App.Enum.InvitationStatus');
});

test('an appended accessor is optional and typed from its docblock', function (): void {
    $shape = ModelShape::for(Monster::class);

    expect($shape['icon_url']->type)->toBe('string')
        ->and($shape['icon_url']->optional)->toBeTrue();
});

// `unknown` is not a type error. An appended accessor left at unknown would
// typecheck against every access, which is the failure this generator exists
// to prevent, so it is refused outright rather than emitted.
test('an appended accessor with no docblock is refused', function (): void {
    expect(fn () => ModelShape::for(FixtureModelWithUndocumentedAppend::class))
        ->toThrow(RuntimeException::class, 'has no @typescript');
});

test('a docblock can describe a shape no reflection could reach', function (): void {
    $shape = ModelShape::for(Monster::class);

    expect($shape['mechanics']->type)->toContain('title: string');
});

class FixtureModelWithUndocumentedAppend extends Illuminate\Database\Eloquent\Model
{
    protected $table = 'crafts';

    protected $appends = ['undocumented'];

    public function getUndocumentedAttribute(): string
    {
        return 'x';
    }
}

class FixtureModelWithUnallowedVendorRelation extends Illuminate\Database\Eloquent\Model
{
    protected $table = 'crafts';

    public function notification(): Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Illuminate\Notifications\DatabaseNotification::class, 'user_id');
    }
}
