<script setup>
import BitbucketIcon from '@/Components/SocialstreamIcons/BitbucketIcon.vue';
import FacebookIcon from '@/Components/SocialstreamIcons/FacebookIcon.vue';
import GithubIcon from '@/Components/SocialstreamIcons/GithubIcon.vue';
import GitLabIcon from '@/Components/SocialstreamIcons/GitLabIcon.vue';
import GoogleIcon from '@/Components/SocialstreamIcons/GoogleIcon.vue';
import LinkedInIcon from '@/Components/SocialstreamIcons/LinkedInIcon.vue';
import TwitterIcon from '@/Components/SocialstreamIcons/TwitterIcon.vue';
import DiscordIcon from "@/Components/SocialstreamIcons/DiscordIcon.vue";

defineProps({
    provider: String,
    createdAt: {
        type: String,
        default: null,
    }
});
</script>

<template>
    <div>
        <div class="px-3 flex items-center justify-between">
            <div class="flex items-center">
                <FacebookIcon
                    v-if="provider === 'facebook'"
                    class="h-6 w-6 mr-2 p-1 rounded-full bg-white"
                />
                <GoogleIcon
                    v-if="provider === 'google'"
                    class="h-6 w-6 mr-2 p-1 rounded-full bg-white"
                />
                <TwitterIcon
                    v-if="['twitter', 'twitter-oauth-2'].includes(provider)"
                    class="h-6 w-6 mr-2 p-1 rounded-full bg-white"
                />
                <LinkedInIcon
                    v-if="provider === 'linkedin'"
                    class="h-6 w-6 mr-2 p-1 rounded-full bg-white"
                />
                <GithubIcon
                    v-if="provider === 'github'"
                    class="h-6 w-6 mr-2 p-1 rounded-full bg-white"
                />
                <GitLabIcon
                    v-if="provider === 'gitlab'"
                    class="h-6 w-6 mr-2 p-1 rounded-full bg-white"
                />
                <BitbucketIcon
                    v-if="provider === 'bitbucket'"
                    class="h-6 w-6 mr-2 p-1 rounded-full bg-white"
                />
                <DiscordIcon
                    v-if="provider === 'discord'"
                    class="h-6 w-6 mr-2 p-1 rounded-full bg-white"
                />

                <div>
                    <div class="text-sm font-semibold text-gray-600 dark:text-gray-400">
                        {{ provider === 'twitter-oauth-2' ? 'Twitter' : provider.charAt(0).toUpperCase() + provider.slice(1) }}
                    </div>

                    <div
                        v-if="createdAt !== null"
                        class="text-xs text-gray-500"
                    >
                        {{ $t('Connected') }} {{ createdAt }}
                    </div>

                    <div
                        v-else
                        class="text-xs text-gray-500"
                    >
                        {{ $t('Not connected.') }}
                    </div>
                </div>
            </div>

            <slot name="action" />
        </div>
    </div>
</template>
