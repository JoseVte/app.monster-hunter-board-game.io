<?php

// 106 components are still JavaScript and that is fine; what is not fine is
// 107. Without this the next component is copied from its nearest neighbour,
// which is untyped, and "incremental" quietly becomes "never".
//
// The count is asserted from three ends, not one. A glob that matches nothing
// would make the ceiling trivially true, which is exactly how this repository
// has twice shipped a green check that checked nothing: a typecheck over 175
// files that read none of them, and a smoke test whose glob could have
// matched zero. 21 of the 165 `.vue` files carry no `<script>` block at all
// (pure template icons); a file with no script can never carry `lang="ts"`,
// so they are excluded from the untyped count rather than left in it to
// quietly weaken what the ceiling measures. Asserting the with-script count
// too means that exclusion cannot silently swallow a file that does have a
// script.
test('the number of components without lang="ts" never rises', function (): void {
    $all = [];
    $directory = new RecursiveDirectoryIterator(resource_path('js'));
    foreach (new RecursiveIteratorIterator($directory) as $file) {
        if ($file->isFile() && $file->getExtension() === 'vue') {
            $all[] = $file->getPathname();
        }
    }

    expect($all)->toHaveCount(165, 'The total number of .vue files moved.');

    $withScript = array_values(array_filter(
        $all,
        fn (string $path): bool => str_contains(file_get_contents($path), '<script'),
    ));

    expect($withScript)->toHaveCount(144, 'The number of .vue files with a <script> block moved.');

    // `preg_match` rather than `str_contains('lang="ts"', ...)`: a single-quoted
    // `lang='ts'` is valid Vue SFC syntax and would otherwise count as untyped.
    $untyped = array_values(array_filter(
        $withScript,
        fn (string $path): bool => ! preg_match('/lang=[\'"]ts[\'"]/', file_get_contents($path)),
    ));

    expect($untyped)->toHaveCount(
        106,
        "The ceiling moved. If you converted components, lower it. If you added an untyped one, don't:\n"
        .implode("\n", $untyped)
    );
});
