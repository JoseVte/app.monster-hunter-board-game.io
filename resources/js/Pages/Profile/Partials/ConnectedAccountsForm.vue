<script setup>
import {computed} from 'vue';
import {useForm, usePage} from '@inertiajs/vue3';
import ActionSection from '@/Components/ActionSection.vue';
import DangerButton from '@/Components/DangerButton.vue';
import GithubIcon from '@/Components/SocialstreamIcons/GithubIcon.vue';
import GoogleIcon from '@/Components/SocialstreamIcons/GoogleIcon.vue';
import DiscordIcon from '@/Components/SocialstreamIcons/DiscordIcon.vue';

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

const social = computed(() => usePage().props.socialLogin);
const providers = computed(() => social.value?.providers ?? []);
const linked = computed(() => social.value?.linked ?? []);

const isLinked = (provider) => linked.value.includes(provider);

// The last remaining provider can only be unlinked once a password exists,
// otherwise the account would have no way left to sign in.
const canUnlink = (provider) => isLinked(provider)
    && (linked.value.length > 1 || social.value?.hasPassword);

const form = useForm({});

const unlink = (provider) => form.delete(route('profile.social.unlink', provider), {
    preserveScroll: true,
});
</script>

<template>
    <ActionSection>
        <template #title>
            {{ $t('Connected Accounts') }}
        </template>

        <template #description>
            {{ $t('Manage the social accounts you can sign in with.') }}
        </template>

        <template #content>
            <div class="space-y-4">
                <div
                    v-for="provider in providers"
                    :key="provider"
                    class="flex items-center justify-between p-3 rounded-md bg-gray-100 dark:bg-gray-900"
                >
                    <div class="flex items-center gap-3">
                        <component
                            :is="icons[provider]"
                            class="h-8 w-8 p-1 rounded-full bg-white"
                        />
                        <div>
                            <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                {{ labels[provider] }}
                            </div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">
                                {{ isLinked(provider) ? $t('Connected') : $t('Not connected') }}
                            </div>
                        </div>
                    </div>

                    <DangerButton
                        v-if="canUnlink(provider)"
                        :disabled="form.processing"
                        @click="unlink(provider)"
                    >
                        {{ $t('Remove') }}
                    </DangerButton>

                    <a
                        v-else-if="! isLinked(provider)"
                        :href="route('profile.social.redirect', provider)"
                        class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white transition"
                    >
                        {{ $t('Connect') }}
                    </a>
                </div>
            </div>
        </template>
    </ActionSection>
</template>
