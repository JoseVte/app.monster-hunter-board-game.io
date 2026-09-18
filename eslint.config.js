import js from '@eslint/js';
import globals from 'globals';
import pluginVue from 'eslint-plugin-vue';
import pluginImport from 'eslint-plugin-import-x';

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

    {
        files: ['**/*.js', '**/*.mjs', '**/*.cjs', '**/*.vue'],

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
