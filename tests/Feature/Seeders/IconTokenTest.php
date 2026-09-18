<?php

/**
 * The seed data marks a game symbol as `:name:`, usually but not always ending
 * in `_icon`. Nothing tied the data to the frontend map, so the map had drifted
 * and one token had been written without its leading colon.
 */
function seedDataTokens(): array
{
    $text = collect(glob(database_path('seeders/data/*.php')))
        ->merge(glob(database_path('seeders/data/weapons/*.php')))
        ->map(fn (string $file): string => file_get_contents($file))
        ->implode("\n");

    preg_match_all('/:([a-z0-9_]+):/', $text, $matches);

    return array_values(array_unique($matches[1]));
}

function mappedIcons(): array
{
    preg_match_all(
        '/^    ([a-z0-9_]+): \{ src:/m',
        file_get_contents(resource_path('js/icons.js')),
        $matches,
    );

    return $matches[1];
}

function pendingIcons(): array
{
    $source = file_get_contents(resource_path('js/icons.js'));
    $block = substr($source, strpos($source, 'const pending = {'));
    $block = substr($block, 0, strpos($block, '};'));

    preg_match_all('/^    ([a-z0-9_]+):/m', $block, $matches);

    return $matches[1];
}

test('no icon token is written without its leading colon', function (): void {
    $malformed = [];

    foreach (array_merge(glob(database_path('seeders/data/*.php')), glob(database_path('seeders/data/weapons/*.php'))) as $file) {
        foreach (file($file) as $number => $line) {
            if (preg_match('/(?<!:)\b[a-z0-9_]*_icon(_[a-z0-9]+)?:/', $line)) {
                $malformed[] = basename($file).':'.($number + 1);
            }
        }
    }

    expect($malformed)->toBeEmpty();
});

test('every icon token the data uses is known to the frontend', function (): void {
    $known = array_merge(mappedIcons(), pendingIcons());

    // Monster abilities, mechanics and rewards carry tokens too, and MonstersSeeder
    // now reads and seeds resistance, setup, mechanics (with ability and parts) and
    // rewards, so all of that reaches a page. Most of what it carries already has
    // artwork or a pending label; what is left here still renders, through the
    // auto-humanized fallback badge rather than a curated one. They are listed
    // rather than ignored: a genuinely new, unmapped token still fails this test
    // and says exactly which symbol needs triage.
    $notSeededYet = [
        'back_icon', 'claw_icon', 'dodge_icon', 'head_icon', 'leg_icon',
        'movement_icon', 'range_icon', 'black_spike_icon', 'nergigante_icon',
        'paw_icon', 'spike_icon', 'supernova_icon', 'tail_icon',
        'tornado_icon', 'wing_icon',
    ];

    $unknown = array_values(array_diff(seedDataTokens(), $known, $notSeededYet));

    expect($unknown)->toBeEmpty();
});

test('every mapped icon points at a file that exists', function (): void {
    preg_match_all(
        "/^import [a-zA-Z]+ from '~\/((?:types|icons)\/[^']+)';/m",
        file_get_contents(resource_path('js/icons.js')),
        $matches,
    );

    $missing = collect($matches[1])
        ->reject(fn (string $path): bool => is_file(resource_path("images/$path")))
        ->all();

    expect($matches[1])->not->toBeEmpty()
        ->and($missing)->toBeEmpty();
});

test('an icon is either drawn or pending, never both', function (): void {
    expect(array_intersect(mappedIcons(), pendingIcons()))->toBeEmpty();
});

test('nothing is left pending that the data never mentions', function (): void {
    expect(array_diff(pendingIcons(), seedDataTokens()))->toBeEmpty();
});

test('no icon token is written with brackets instead of colons', function (): void {
    // gunlance.php wrote [shelling_up_icon] and [damage_card_icon], which the
    // replacement never looked for, so they reached the stored description as
    // literal brackets.
    $bracketed = [];

    foreach (array_merge(glob(database_path('seeders/data/*.php')), glob(database_path('seeders/data/weapons/*.php'))) as $file) {
        foreach (file($file) as $number => $line) {
            if (preg_match('/\[[a-z0-9_]+_icon[a-z0-9_]*\]/', $line)) {
                $bracketed[] = basename($file).':'.($number + 1);
            }
        }
    }

    expect($bracketed)->toBeEmpty();
});

test('no seed text carries an escaped newline instead of a line break', function (): void {
    // Single quoted PHP does not interpret \n, so it reaches the database as a
    // backslash and an n. Every other file breaks lines with <br>.
    $escaped = [];

    foreach (array_merge(glob(database_path('seeders/data/*.php')), glob(database_path('seeders/data/weapons/*.php'))) as $file) {
        foreach (file($file) as $number => $line) {
            if (str_contains($line, '\n')) {
                $escaped[] = basename($file).':'.($number + 1);
            }
        }
    }

    expect($escaped)->toBeEmpty();
});
