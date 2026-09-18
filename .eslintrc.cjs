module.exports = {
    "env": {
        "browser": true,
        "es2021": true
    },
    "extends": [
        "eslint:recommended",
        "plugin:vue/vue3-recommended",
        "plugin:import/recommended"
    ],
    "overrides": [
    ],
    "parserOptions": {
        "ecmaVersion": "latest",
        "sourceType": "module"
    },
    "plugins": [
        "vue",
        "import"
    ],
    "rules": {
        "import/no-unresolved": ["off"],
        "import/order": ["error"],
        "indent": ["error", 4],
        "no-undef": ["off"],
        "vue/html-indent": ["error", 4],
        "vue/multi-word-component-names": ["off"],
        "vue/no-v-html": ["off"],
        "vue/require-default-prop": ["off"],
    }
}
