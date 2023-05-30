<script setup>
import InputLabel from '@/Components/Form/InputLabel.vue';
import ActionSection from "@/Components/ActionSection.vue";

defineProps({
    campaign: Object,
});
</script>

<template>
    <ActionSection>
        <template #title>
            {{ $t('Campaign Owner') }}
        </template>

        <template #description>
            {{ $t('The campaign\'s owner information.') }}
        </template>

        <template #content>
            <!-- Campaign Owner Information -->
            <div class="col-span-6">
                <InputLabel :value="$t('Team')" />

                <div class="flex items-center mt-2">
                    <img
                        class="w-12 h-12 rounded-full object-cover"
                        :src="campaign.team.owner.profile_photo_url"
                        :alt="campaign.team.owner.name"
                    >

                    <div class="ml-4 leading-tight">
                        <div class="text-gray-900 dark:text-white">
                            {{ campaign.team.name }}
                        </div>
                        <div class="text-gray-700 dark:text-gray-300 text-sm">
                            {{ campaign.team.owner.name }} <span class="text-gray-600 dark:text-gray-400">{{ campaign.team.owner.email }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </ActionSection>
</template>
