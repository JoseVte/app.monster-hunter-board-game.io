<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<!--
    The privacy policy and the terms used to be reachable from exactly one place,
    the checkbox on the registration form, and registration is closed by default,
    so a visitor had no way to open either of them.
-->
<template>
    <footer class="border-t border-gray-200 px-4 py-6 sm:px-6 lg:px-8 dark:border-gray-700">
        <div class="mx-auto flex max-w-7xl flex-col gap-3 text-xs text-gray-500 sm:flex-row sm:items-center sm:justify-between dark:text-gray-400">
            <p>{{ $t('Not affiliated with Capcom or Steamforged Games.') }}</p>

            <nav class="flex gap-4">
                <Link
                    :href="route('policy.show')"
                    class="hover:text-gray-900 hover:underline dark:hover:text-gray-100"
                >
                    {{ $t('Privacy Policy') }}
                </Link>
                <Link
                    :href="route('terms.show')"
                    class="hover:text-gray-900 hover:underline dark:hover:text-gray-100"
                >
                    {{ $t('Terms of Service') }}
                </Link>
            </nav>
        </div>
    </footer>
</template>
