<?php

namespace App\Support\TypeScript;

use ReflectionClass;
use ReflectionMethod;
use RuntimeException;
use ReflectionNamedType;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use App\Enum\Traits\TranslatableEnum;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

/**
 * The shape one model takes once Inertia has serialised it.
 *
 * Deliberately not the table and not the model. `HasTranslations::toArray()`
 * rewrites the payload on the way out, so a type read off the schema alone is
 * wrong for every translatable column and every translatable enum cast, and a
 * type that is wrong is worse than none: the typecheck then goes green exactly
 * where the code is not.
 */
class ModelShape
{
    /** SQLite and MySQL disagree on names, so both spellings are mapped. */
    private const COLUMN_TYPES = [
        'bigint' => 'number',
        'int' => 'number',
        'integer' => 'number',
        'smallint' => 'number',
        'tinyint' => 'number',
        'decimal' => 'number',
        'float' => 'number',
        'double' => 'number',
        'numeric' => 'number',
        'boolean' => 'boolean',
        'json' => 'unknown[]',
        'varchar' => 'string',
        'char' => 'string',
        'text' => 'string',
        'mediumtext' => 'string',
        'longtext' => 'string',
        'date' => 'string',
        'datetime' => 'string',
        'timestamp' => 'string',
    ];

    // Measured against this schema, these nine names cover every column:
    // bigint 67, timestamp 65, json 26, tinyint 25, int 22, varchar 44,
    // text 8, smallint 1, datetime 1. A name not listed becomes `unknown`,
    // which is a signal to extend the map, not a type to ship.

    private const CAST_TYPES = [
        'int' => 'number',
        'integer' => 'number',
        'real' => 'number',
        'float' => 'number',
        'double' => 'number',
        'decimal' => 'number',
        'string' => 'string',
        'bool' => 'boolean',
        'boolean' => 'boolean',
        'array' => 'unknown[]',
        'json' => 'unknown[]',
        'collection' => 'unknown[]',
        'object' => 'Record<string, unknown>',
        'date' => 'string',
        'datetime' => 'string',
        'immutable_date' => 'string',
        'immutable_datetime' => 'string',
        'timestamp' => 'number',
    ];

    /** @return array<string, ModelProperty> */
    public static function for(string $modelClass): array
    {
        /** @var Model $model */
        $model = new $modelClass;

        $table = $model->getTable();

        if (! Schema::hasTable($table)) {
            throw new RuntimeException(
                "Cannot describe [{$modelClass}]: its table [{$table}] does not exist. "
                .'Run `php artisan migrate` before generating types.'
            );
        }

        $casts = $model->getCasts();
        $hidden = $model->getHidden();
        $translatable = method_exists($model, 'getTranslatableAttributes')
            ? $model->getTranslatableAttributes()
            : [];
        $docblock = self::docblockProperties($modelClass);

        $properties = [];

        foreach (Schema::getColumns($table) as $column) {
            $name = $column['name'];

            if (in_array($name, $hidden, true)) {
                continue;
            }

            $type = match (true) {
                isset($docblock[$name]) => $docblock[$name],
                // toArray() flattens this to the current locale on the way out.
                in_array($name, $translatable, true) => 'string',
                // ... and replaces a TranslatableEnum cast with its label.
                isset($casts[$name]) && self::isTranslatableEnum($casts[$name]) => 'string',
                isset($casts[$name]) => self::fromCast($casts[$name]),
                default => self::COLUMN_TYPES[$column['type_name']] ?? 'unknown',
            };

            if ($column['nullable']) {
                $type .= ' | null';
            }

            $properties[$name] = new ModelProperty($name, $type);
        }

        foreach (self::appends($model) as $name) {
            if (! isset($docblock[$name])) {
                throw new RuntimeException(
                    "[{$modelClass}] appends [{$name}] but has no @typescript for it. An accessor's "
                    .'type cannot be derived, and leaving it `unknown` would typecheck against '
                    .'anything, which is the failure these types exist to prevent.'
                );
            }

            $properties[$name] = new ModelProperty($name, $docblock[$name], optional: true);
        }

        foreach (self::relations($model) as $name => $property) {
            $properties[$name] = $property;
        }

        return $properties;
    }

    private const TO_MANY = [
        HasMany::class,
        BelongsToMany::class,
        HasManyThrough::class,
        MorphMany::class,
        MorphToMany::class,
    ];

    /**
     * Related classes that live outside `app/`, so `typescript:transform`'s
     * `transformDirectories(app_path())` never walks them and never emits an
     * `App.Models.*` type for them on its own. Each entry here has a matching
     * hand-written declaration in `resources/js/types/vendor-models.d.ts`;
     * adding a relation to a new vendor model means writing that declaration
     * first and listing the class here, not just adding it to this array.
     */
    private const VENDOR_MODELS = [
        Role::class,
        Permission::class,
    ];

    /**
     * A relation only reaches the frontend when the controller eager loaded it,
     * so every one of these is optional. The alternative asserts it is always
     * present, which is precisely the runtime error these types exist to catch.
     *
     * @return array<string, ModelProperty>
     */
    private static function relations(Model $model): array
    {
        $properties = [];

        foreach ((new ReflectionClass($model))->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {
            if ($method->getNumberOfParameters() > 0 || $method->isStatic()) {
                continue;
            }

            $returnType = $method->getReturnType();

            // Jetstream's Team::users(), Team::owner() and HasTeams::teams()
            // declare no return type, so this guard drops them along with
            // every other untyped relation on a vendor parent nobody here can
            // annotate. The direction is the safe one: an absent relation is a
            // compile error the moment a component reads it, never a lie the
            // typechecker waves through. Concretely, `App.Models.Team` has no
            // `users` or `owner`, and `App.Models.User` has no `teams`,
            // `current_team` or `owned_teams`, even though Jetstream's own
            // `ShareInertiaData` puts `current_team` and `all_teams` on
            // `auth.user` on every request; see `vendor-models.d.ts` for how
            // that gap is covered by hand.
            if (! $returnType instanceof ReflectionNamedType
                || $returnType->isBuiltin()
                || ! is_a($returnType->getName(), Relation::class, true)) {
                continue;
            }

            // A MorphTo cannot be described from an unsaved model. The morph
            // type column is unset, so morphTo() falls through to
            // morphEagerTo() and builds the relation off the parent's own
            // query: Craft::craftable() would come back as Craft, a model
            // describing itself. Skipping leaves the key undeclared, which
            // makes reading it a compile error rather than a silent lie.
            if (is_a($returnType->getName(), MorphTo::class, true)) {
                continue;
            }

            $related = $model->{$method->getName()}()->getRelated()::class;

            if (! Str::startsWith($related, 'App\\Models\\') && ! in_array($related, self::VENDOR_MODELS, true)) {
                $modelName = $model::class;

                throw new RuntimeException(
                    "[{$modelName}] relation [{$method->getName()}] returns [{$related}], which is "
                    .'neither under App\Models nor in ModelShape::VENDOR_MODELS. The transformer only '
                    .'walks app_path(), so `App.Models.'.class_basename($related).'` would name a type '
                    .'nobody declares, and `skipLibCheck` would hide that as `any` rather than a '
                    .'compile error, worse than the `unknown` this generator already refuses elsewhere. '
                    .'Declare '.class_basename($related).' by hand in resources/js/types/vendor-models.d.ts '
                    .'and add it to ModelShape::VENDOR_MODELS.'
                );
            }

            $type = 'App.Models.'.class_basename($related);

            $isMany = false;

            foreach (self::TO_MANY as $many) {
                $isMany = $isMany || is_a($returnType->getName(), $many, true);
            }

            $key = Str::snake($method->getName());

            $properties[$key] = new ModelProperty(
                $key,
                $isMany ? "Array<{$type}>" : $type,
                optional: true,
            );

            $properties["{$key}_count"] = new ModelProperty("{$key}_count", 'number', optional: true);
        }

        return $properties;
    }

    private static function fromCast(string $cast): string
    {
        // A cast may carry arguments, as in `decimal:2`.
        $name = explode(':', $cast, 2)[0];

        return self::CAST_TYPES[$name] ?? 'unknown';
    }

    private static function isTranslatableEnum(string $cast): bool
    {
        return class_exists($cast)
            && in_array(TranslatableEnum::class, class_uses_recursive($cast), true);
    }

    /**
     * A class level `@typescript` wins over everything derived.
     *
     * Deliberately not `@property`: the value on the right is TypeScript, not
     * PHP, and `@property` is read by PhpStorm, by `php artisan
     * ide-helper:models`, and by any static analyser, all of which are PHP
     * tooling that would then be told the model has a real property of a class
     * called, say, `App.Enum.InvitationStatus`, which does not exist in PHP at
     * all. `@typescript` is a tag nothing but this parser reads.
     *
     * This is the escape hatch for what reflection cannot reach: an appended
     * accessor's return shape, and Monster::mechanics(), a custom Attribute
     * holding a nested structure resolved to one locale on read. Used as an
     * override it is a handful of lines across the app. Used as the only source,
     * as an earlier design proposed, it would not work at all: ClassTransformer
     * iterates real public PHP properties and an Eloquent model has none.
     *
     * @return array<string, string>
     */
    private static function docblockProperties(string $modelClass): array
    {
        $docblock = (new ReflectionClass($modelClass))->getDocComment();

        if ($docblock === false) {
            return [];
        }

        preg_match_all('/@typescript\s+(?<type>.+?)\s+\$(?<name>\w+)/', $docblock, $matches, PREG_SET_ORDER);

        return array_reduce(
            $matches,
            function (array $carry, array $match): array {
                $carry[$match['name']] = trim($match['type']);

                return $carry;
            },
            [],
        );
    }

    /** @return array<int, string> */
    private static function appends(Model $model): array
    {
        $property = (new ReflectionClass($model))->getProperty('appends');

        return $property->getValue($model);
    }
}
