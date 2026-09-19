<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Pages
    |--------------------------------------------------------------------------
    |
    | Only this key is overridden. The package default points `paths` at
    | `resource_path('js/pages')`, lowercase, which is the convention the newer
    | Laravel starter kits use; this project keeps `resources/js/Pages`, which is
    | also what `resources/js/app.js` and `ssr.js` glob.
    |
    | Nothing breaks at runtime, because `pages.ensure_pages_exist` is false and
    | the frontend resolves a component against the Vite bundle rather than the
    | filesystem. It is `assertInertia` that pays for it: `testing`.
    | `ensure_pages_exist` is true, so it looks the file up on disk. A
    | case-insensitive filesystem answers for the wrong case, so the suite passes
    | on macOS and every Inertia assertion fails on the Linux CI runner.
    |
    | The whole `pages` key has to be written out: the service provider merges
    | with `mergeConfigFrom`, which only merges the top level, so a partial array
    | here would drop the sibling keys rather than inherit them.
    |
    */

    'pages' => [

        'ensure_pages_exist' => false,

        'paths' => [

            resource_path('js/Pages'),

        ],

        'extensions' => [

            'js',
            'jsx',
            'svelte',
            'ts',
            'tsx',
            'vue',

        ],

    ],

];
