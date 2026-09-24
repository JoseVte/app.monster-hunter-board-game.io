<script setup>
//
// Google's terms ask for the reCAPTCHA badge or a visible attribution, one or
// the other. resources/js/recaptcha.ts keeps the badge hidden, so this is what
// holds up that end of the bargain. Any form that calls useRecaptcha needs it.
//
// The links are composed here rather than inside the translated string.
// `composer generate-translations` rewrites `:name` to `{name}` in the key as
// well as the value, so a key with a placeholder in it stops matching what
// $t() looks up and the raw sentence renders instead.
//
</script>

<template>
    <p class="mt-4 text-xs text-gray-500 dark:text-gray-400">
        {{ $t('This site is protected by reCAPTCHA and the Google') }}
        <a
            href="https://policies.google.com/privacy"
            target="_blank"
            rel="noopener noreferrer"
            class="underline hover:text-gray-900 dark:hover:text-gray-100"
        >{{ $t('Privacy Policy') }}</a>
        {{ $t('and') }}
        <a
            href="https://policies.google.com/terms"
            target="_blank"
            rel="noopener noreferrer"
            class="underline hover:text-gray-900 dark:hover:text-gray-100"
        >{{ $t('Terms of Service') }}</a>
        {{ $t('apply.') }}
    </p>
</template>
