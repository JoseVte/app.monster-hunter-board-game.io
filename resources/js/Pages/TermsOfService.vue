<script setup>
import { Head } from '@inertiajs/vue3';
import AuthenticationCardLogo from '@/Components/AuthenticationCardLogo.vue';

defineProps({
    terms: String,
});
</script>

<template>
    <Head :title="$t('Terms of Service')" />

    <div class="font-sans text-gray-900 dark:text-gray-100 antialiased">
        <div class="pt-4 bg-gray-100 dark:bg-gray-900">
            <div class="min-h-screen flex flex-col items-center pt-6 sm:pt-0">
                <div>
                    <AuthenticationCardLogo />
                </div>

                <div
                    class="mh-frame prose mt-6 w-full bg-white p-6 sm:max-w-2xl dark:prose-invert dark:bg-gray-800"
                    v-html="terms"
                />
            </div>
        </div>
    </div>
</template>
