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
];
