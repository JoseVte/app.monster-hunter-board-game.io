<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import ActionSection from '@/Components/ActionSection.vue';
import ConfirmationModal from '@/Components/ConfirmationModal.vue';
import DangerButton from '@/Components/DangerButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';

const props = defineProps({
    campaign: Object,
});

const confirmingCampaignDeletion = ref(false);
const form = useForm({});

const confirmCampaignDeletion = () => {
    confirmingCampaignDeletion.value = true;
};

const deleteCampaign = () => {
    form.delete(route('campaigns.destroy', props.campaign), {
        errorBag: 'deleteCampaign',
    });
};
</script>

<template>
    <ActionSection>
        <template #title>
            {{ $t('Delete Campaign') }}
        </template>

        <template #description>
            {{ $t('Permanently delete this campaign.') }}
        </template>

        <template #content>
            <div class="max-w-xl text-sm text-gray-600 dark:text-gray-400">
                {{ $t('Once a campaign is deleted, all of its resources and data will be permanently deleted.Before deleting this campaign, please download any data or information regarding this campaign that you wish to retain.') }}
            </div>

            <div class="mt-5">
                <DangerButton @click="confirmCampaignDeletion">
                    {{ $t('Delete Campaign') }}
                </DangerButton>
            </div>

            <!-- Delete Team Confirmation Modal -->
            <ConfirmationModal
                :show="confirmingCampaignDeletion"
                @close="confirmingCampaignDeletion = false"
            >
                <template #title>
                    {{ $t('Delete Campaign') }}
                </template>

                <template #content>
                    {{ $t('Are you sure you want to delete this team? Once a team is deleted, all of its resources and data will be permanently deleted.') }}
                </template>

                <template #footer>
                    <SecondaryButton @click="confirmingCampaignDeletion = false">
                        {{ $t('Cancel') }}
                    </SecondaryButton>

                    <DangerButton
                        class="ml-3"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                        @click="deleteCampaign"
                    >
                        {{ $t('Delete Campaign') }}
                    </DangerButton>
                </template>
            </ConfirmationModal>
        </template>
    </ActionSection>
</template>
