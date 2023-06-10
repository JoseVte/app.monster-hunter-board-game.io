<script setup>
import {Link} from '@inertiajs/vue3';
import WeaponsIcon from "@/Components/Icons/WeaponsIcon.vue";
</script>

<template>
    <div
        v-if="!$page.props.has_campaign_hunter && $page.props.current_campaign"
        class="bg-primary-500"
    >
        <div class="max-w-screen-xl mx-auto py-2 px-3 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between flex-wrap">
                <Link
                    :href="route('campaigns.hunters.create', $page.props.current_campaign)"
                    class="w-0 flex-1 flex items-center min-w-0"
                >
                    <span class="flex p-2 rounded-lg bg-primary-600">
                        <WeaponsIcon class="h-5 w-5 text-white" />
                    </span>

                    <p class="ml-3 font-medium text-sm text-white truncate">
                        {{ $t('Create a hunter for this campaign to continue.') }}
                    </p>
                </Link>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
