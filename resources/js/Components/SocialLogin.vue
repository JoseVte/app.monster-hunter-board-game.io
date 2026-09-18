<script setup>
import {computed} from 'vue';
import {usePage} from '@inertiajs/vue3';
import GithubIcon from '@/Components/SocialstreamIcons/GithubIcon.vue';
import GoogleIcon from '@/Components/SocialstreamIcons/GoogleIcon.vue';
import DiscordIcon from '@/Components/SocialstreamIcons/DiscordIcon.vue';
import InputError from '@/Components/Form/InputError.vue';

const icons = {
    google: GoogleIcon,
    github: GithubIcon,
    discord: DiscordIcon,
};

const labels = {
    google: 'Google',
    github: 'GitHub',
    discord: 'Discord',
};

const providers = computed(() => usePage().props.socialLogin?.providers ?? []);
const error = computed(() => usePage().props.errors?.socialLogin);
</script>

<template>
    <div v-if="providers.length">
        <div class="flex flex-row items-center justify-between py-4 text-gray-500">
            <hr class="w-full mr-2">
            {{ $t('Or') }}
            <hr class="w-full ml-2">
        </div>

        <div class="flex items-center justify-center">
            <a
                v-for="provider in providers"
                :key="provider"
                :href="route('auth.social.redirect', provider)"
            >
                <component
                    :is="icons[provider]"
                    class="h-8 w-8 mx-2 p-1 rounded-full bg-white"
                />
                <span class="sr-only">{{ labels[provider] }}</span>
            </a>
        </div>

        <InputError
            :message="error"
            class="mt-2 text-center"
        />
    </div>
</template>
