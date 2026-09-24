import js from '@eslint/js';
import globals from 'globals';
import pluginVue from 'eslint-plugin-vue';
import pluginImport from 'eslint-plugin-import-x';
import tseslint from 'typescript-eslint';
import vueEslintParser from 'vue-eslint-parser';

export default [
    {
        ignores: [
            'bootstrap/**',
            'node_modules/**',
            'public/**',
            'reports/**',
            'vendor/**',
            'resources/js/vue-i18n-locales.generated.js',
        ],
    },

    js.configs.recommended,
    ...pluginVue.configs['flat/recommended'],
    // tseslint.configs.recommended is 3 sub-configs, and one of them
    // ('typescript-eslint/eslint-recommended') already scopes itself to **/*.ts (and friends),
    // deliberately excluding .vue. Only default a 'files' scope where one is missing, instead of
    // overwriting every sub-config's files unconditionally: doing the latter would widen that
    // already-scoped sub-config onto .vue too, which both disables core rules it turns off for
    // TS-only files (e.g. no-redeclare, no-dupe-class-members) and newly enables ones it turns on
    // (prefer-const, no-var) for every plain-JS .vue file in the project.
    ...tseslint.configs.recommended.map((config) => ({
        ...config,
        files: config.files ?? ['**/*.ts', '**/*.vue'],
    })),

    // This block must stay textually AFTER the tseslint.configs.recommended spread above:
    // that spread's unscoped base config sets languageOptions.parser for every file it matches,
    // and would otherwise clobber vue-eslint-parser for .vue files. The recommended spread is
    // now scoped to **/*.ts and **/*.vue, so plain .js/.cjs/.mjs files are unaffected by any
    // TypeScript-specific rules.
    {
        files: ['**/*.vue'],
        languageOptions: {
            parser: vueEslintParser,
            parserOptions: {
                parser: tseslint.parser,
            },
        },
    },

    // Must stay after both blocks above: `no-redeclare` and
    // `no-dupe-class-members` are the two core rules
    // `typescript-eslint/eslint-recommended` (inside the `tseslint.configs.
    // recommended` spread) turns off again for TypeScript's own overload
    // syntax, real duplicates in plain JS/Vue but false positives against a
    // second `function foo(...)` or class member signature that only
    // narrows an earlier one. That sub-config self-scopes to `**/*.ts` (see
    // the comment on the spread above), which a `lang="ts"` `<script>` block
    // inside a `.vue` file never matches, so the false positive survives
    // there. `resources/js/__tests__/setup.ts:mockRoute` uses overloads and
    // only escapes this because it is a bare `.ts` file; the first converted
    // component to do the same inside a `.vue` file would not. ESLint
    // resolves a rule from the last matching config, so this has to come
    // after the tseslint spread to win rather than be overridden by it.
    {
        files: ['**/*.vue'],
        rules: {
            'no-redeclare': ['off'],
            'no-dupe-class-members': ['off'],
        },
    },

    {
        files: ['**/*.js', '**/*.mjs', '**/*.cjs', '**/*.ts', '**/*.vue'],

        languageOptions: {
            ecmaVersion: 'latest',
            sourceType: 'module',
            globals: {
                ...globals.browser,
                route: 'readonly',
            },
        },

        plugins: {
            'import-x': pluginImport,
        },

        rules: {
            'import-x/no-unresolved': ['off'],
            'import-x/order': ['error'],
            'indent': ['error', 4],
            'no-undef': ['off'],
            'vue/html-indent': ['error', 4],
            'vue/multi-word-component-names': ['off'],
            // A component used in a template but never imported builds and
            // lints clean, and shows up as a hole on the page with nothing but
            // a console warning to say so. That happened once already.
            'vue/no-undef-components': ['error'],
            'vue/no-v-html': ['off'],
            'vue/require-default-prop': ['off'],
        },
    },

    {
        files: ['*.config.js', '*.config.mjs', '*.config.cjs', 'postcss.config.cjs', 'tailwind.config.js'],
        languageOptions: {
            globals: globals.node,
        },
    },

    {
        files: ['resources/js/**/*.test.ts', 'resources/js/__tests__/**'],
        languageOptions: {
            globals: {
                ...globals.node,
                describe: 'readonly',
                expect: 'readonly',
                it: 'readonly',
                vi: 'readonly',
                beforeEach: 'readonly',
                afterEach: 'readonly',
            },
        },
    },

    {
        // `interface PageProps extends Inertia.SharedProps {}` in
        // `inertia.d.ts` is how a third-party interface (`@inertiajs/core`'s
        // own `PageProps`) is extended by declaration merging: only an
        // `interface`, not a `type`, merges that way, and the merge is the
        // entire point, so it carries no members of its own. The base rule
        // flags that shape as "equivalent to its supertype", which is true of
        // an empty interface in isolation but not of one whose only job is
        // this merge; `with-single-extends` keeps the rule for every other
        // empty interface while allowing exactly this one pattern.
        files: ['resources/js/types/**/*.d.ts'],
        rules: {
            '@typescript-eslint/no-empty-object-type': ['error', {allowInterfaces: 'with-single-extends'}],
        },
    },
];
