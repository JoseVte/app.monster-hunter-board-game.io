<script setup>
import BitbucketIcon from '@/Components/SocialstreamIcons/BitbucketIcon.vue';
import FacebookIcon from '@/Components/SocialstreamIcons/FacebookIcon.vue';
import GithubIcon from '@/Components/SocialstreamIcons/GithubIcon.vue';
import GitLabIcon from '@/Components/SocialstreamIcons/GitLabIcon.vue';
import GoogleIcon from '@/Components/SocialstreamIcons/GoogleIcon.vue';
import LinkedInIcon from '@/Components/SocialstreamIcons/LinkedInIcon.vue';
import TwitterIcon from '@/Components/SocialstreamIcons/TwitterIcon.vue';

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
                    class="h-6 w-6 mr-2"
                />
                <GoogleIcon
                    v-if="provider === 'google'"
                    class="h-6 w-6 mr-2"
                />
                <TwitterIcon
                    v-if="['twitter', 'twitter-oauth-2'].includes(provider)"
                    class="h-6 w-6 mr-2"
                />
                <LinkedInIcon
                    v-if="provider === 'linkedin'"
                    class="h-6 w-6 mr-2"
                />
                <GithubIcon
                    v-if="provider === 'github'"
                    class="h-6 w-6 mr-2"
                />
                <GitLabIcon
                    v-if="provider === 'gitlab'"
                    class="h-6 w-6 mr-2"
                />
                <BitbucketIcon
                    v-if="provider === 'bitbucket'"
                    class="h-6 w-6 mr-2"
                />

                <div>
                    <div class="text-sm font-semibold text-gray-600">
                        {{ provider === 'twitter-oauth-2' ? 'Twitter' : provider.charAt(0).toUpperCase() + provider.slice(1) }}
                    </div>

                    <div
                        v-if="createdAt !== null"
                        class="text-xs text-gray-500"
                    >
                        Connected {{ createdAt }}
                    </div>

                    <div
                        v-else
                        class="text-xs text-gray-500"
                    >
                        Not connected.
                    </div>
                </div>
            </div>

            <slot name="action" />
        </div>
    </div>
</template>
