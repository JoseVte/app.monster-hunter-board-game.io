<?php

// A generated file that nobody regenerates is worse than no file: it is a type
// that used to be true. This does not re-run the transform, it compares the
// committed output against the models, because Schema::getColumns() returns
// driver specific type names and the developer generates on MySQL while this
// suite runs on SQLite. Names catch the drift that matters: a new column, a
// rename, a new model. It walks every Model subclass under app/Models, not the
// top level alone, so the pivots under app/Models/Pivot are pinned too; the
// non-model files that also live under app/Models (the traits) are skipped.

use App\Support\TypeScript\ModelShape;
use Illuminate\Database\Eloquent\Model;

/**
 * Every `export type Name = {...};` in the generated file, keyed by the fully
 * qualified class name its nesting represents.
 *
 * Keyed on the namespace path rather than the bare name, because a pivot can
 * share a short name with a model declared directly under Models (both a
 * `Models\ArmorSkill` and a `Models\Pivot\ArmorSkill` exist), and a search by
 * name alone would silently grab whichever came first in the file.
 *
 * @return array<string, string>
 */
function generatedTypeBodies(string $generated): array
{
    $bodies = [];
    $namespace = [];
    $current = null;

    foreach (explode("\n", $generated) as $line) {
        $trimmed = trim($line);

        if (preg_match('/^(?:declare )?namespace (\w+) \{$/', $trimmed, $match)) {
            $namespace[] = $match[1];
        } elseif ($trimmed === '}') {
            array_pop($namespace);
        } elseif (preg_match('/^export type (\w+) = \{$/', $trimmed, $match)) {
            $current = implode('\\', [...$namespace, $match[1]]);
            $bodies[$current] = '';
        } elseif ($trimmed === '};') {
            $current = null;
        } elseif ($current !== null) {
            $bodies[$current] .= $line."\n";
        }
    }

    return $bodies;
}

test('every model has an entry in generated.d.ts with the right properties', function (): void {
    $bodies = generatedTypeBodies(file_get_contents(resource_path('js/types/generated.d.ts')));

    $modelsPath = app_path('Models');
    $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($modelsPath, RecursiveDirectoryIterator::SKIP_DOTS));

    foreach ($files as $file) {
        if ($file->getExtension() !== 'php') {
            continue;
        }

        $relative = substr($file->getPathname(), strlen($modelsPath) + 1, -4);
        $model = 'App\\Models\\'.str_replace(DIRECTORY_SEPARATOR, '\\', $relative);

        if (! class_exists($model) || ! is_subclass_of($model, Model::class)) {
            continue;
        }

        expect(array_key_exists($model, $bodies))->toBeTrue("{$model} has no export type in generated.d.ts. Run `composer generate-types`.");

        $declared = [];
        preg_match_all('/^\s*(?<name>\w+)\??:/m', $bodies[$model], $found, PREG_SET_ORDER);
        foreach ($found as $property) {
            $declared[] = $property['name'];
        }

        sort($declared);
        $expected = array_keys(ModelShape::for($model));
        sort($expected);

        expect($declared)->toBe($expected, "{$model} is stale. Run `composer generate-types`.");
    }
});
