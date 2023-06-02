<script setup>
import { ref } from 'vue';
import { router, useForm, usePage } from '@inertiajs/vue3';
import ActionMessage from '@/Components/ActionMessage.vue';
import ActionSection from '@/Components/ActionSection.vue';
import ConfirmationModal from '@/Components/ConfirmationModal.vue';
import DangerButton from '@/Components/DangerButton.vue';
import DialogModal from '@/Components/DialogModal.vue';
import FormSection from '@/Components/Form/FormSection.vue';
import InputError from '@/Components/Form/InputError.vue';
import InputLabel from '@/Components/Form/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import SectionBorder from '@/Components/SectionBorder.vue';
import TextInput from '@/Components/Form/TextInput.vue';

const props = defineProps({
    campaign: Object,
    availableRoles: Array,
    userPermissions: Object,
});

const addCampaignMemberForm = useForm({
    email: '',
    role: null,
});

const updateRoleForm = useForm({
    role: null,
});

const leaveCampaignForm = useForm({});
const removeCampaignMemberForm = useForm({});

const currentlyManagingRole = ref(false);
const managingRoleFor = ref(null);
const confirmingLeavingCampaign = ref(false);
const campaignMemberBeingRemoved = ref(null);

const addCampaignMember = () => {
    addCampaignMemberForm.post(route('campaign-members.store', props.campaign), {
        errorBag: 'addCampaignMember',
        preserveScroll: true,
        onSuccess: () => addCampaignMemberForm.reset(),
    });
};

const cancelCampaignInvitation = (invitation) => {
    router.delete(route('campaign-invitations.destroy', invitation), {
        preserveScroll: true,
    });
};

const manageRole = (campaignMember) => {
    managingRoleFor.value = campaignMember;
    updateRoleForm.role = campaignMember.membership.role.name;
    currentlyManagingRole.value = true;
};

const updateRole = () => {
    updateRoleForm.put(route('campaign-members.update', [props.campaign, managingRoleFor.value]), {
        preserveScroll: true,
        onSuccess: () => currentlyManagingRole.value = false,
    });
};

const confirmLeavingCampaign = () => {
    confirmingLeavingCampaign.value = true;
};

const leaveCampaign = () => {
    leaveCampaignForm.delete(route('campaign-members.destroy', [props.campaign, usePage().props.auth.user]));
};

const confirmCampaignMemberRemoval = (campaignMember) => {
    campaignMemberBeingRemoved.value = campaignMember;
};

const removeCampaignMember = () => {
    removeCampaignMemberForm.delete(route('campaign-members.destroy', [props.campaign, campaignMemberBeingRemoved.value]), {
        errorBag: 'removeCampaignMember',
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => campaignMemberBeingRemoved.value = null,
    });
};

const displayableRole = (role) => {
    return props.availableRoles.find(r => r.key === role) ? props.availableRoles.find(r => r.key === role).name : null;
};
</script>

<template>
    <div>
        <div v-if="campaign.users.length > 0">
            <SectionBorder />

            <!-- Manage Campaign Members -->
            <ActionSection class="mt-10 sm:mt-0">
                <template #title>
                    {{ $t('Campaign Members') }}
                </template>

                <template #description>
                    {{ $t('All of the people that are part of this campaign.') }}
                </template>

                <!-- Campaign Member List -->
                <template #content>
                    <div class="space-y-6">
                        <div
                            v-for="user in campaign.users"
                            :key="user.id"
                            class="flex items-center justify-between"
                        >
                            <div class="flex items-center">
                                <img
                                    class="w-8 h-8 rounded-full"
                                    :src="user.profile_photo_url"
                                    :alt="user.name"
                                >
                                <div class="ml-4 dark:text-white">
                                    {{ user.name }}
                                </div>
                            </div>

                            <div class="flex items-center">
                                <!-- Manage Campaign Member Role -->
                                <button
                                    v-if="userPermissions.canAddCampaignMembers && availableRoles.length"
                                    class="ml-2 text-sm text-gray-400 underline"
                                    @click="manageRole(user)"
                                >
                                    {{ displayableRole(user.membership.role.name) }}
                                </button>

                                <div
                                    v-else-if="availableRoles.length"
                                    class="ml-2 text-sm text-gray-400"
                                >
                                    {{ displayableRole(user.membership.role.name) }}
                                </div>

                                <!-- Leave Campaign -->
                                <button
                                    v-if="$page.props.auth.user.id === user.id"
                                    class="cursor-pointer ml-6 text-sm text-red-500"
                                    @click="confirmLeavingCampaign"
                                >
                                    {{ $t('Leave') }}
                                </button>

                                <!-- Remove Campaign Member -->
                                <button
                                    v-else-if="userPermissions.canRemoveCampaignMembers"
                                    class="cursor-pointer ml-6 text-sm text-red-500"
                                    @click="confirmCampaignMemberRemoval(user)"
                                >
                                    {{ $t('Remove') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </template>
            </ActionSection>
        </div>

        <div v-if="userPermissions.canAddCampaignMembers">
            <SectionBorder />

            <!-- Add Campaign Member -->
            <FormSection @submitted="addCampaignMember">
                <template #title>
                    {{ $t('Add Campaign Member') }}
                </template>

                <template #description>
                    {{ $t('Add a new campaign member to your campaign, allowing them to collaborate with you.') }}
                </template>

                <template #form>
                    <div class="col-span-6">
                        <div class="max-w-xl text-sm text-gray-600 dark:text-gray-400">
                            {{ $t('Please provide the email address of the person you would like to add to this campaign.') }}
                        </div>
                    </div>

                    <!-- Member Email -->
                    <div class="col-span-6 sm:col-span-4">
                        <InputLabel
                            for="email"
                            :value="$t('Email')"
                        />
                        <TextInput
                            id="email"
                            v-model="addCampaignMemberForm.email"
                            type="email"
                            class="mt-1 block w-full"
                        />
                        <InputError
                            :message="addCampaignMemberForm.errors.email"
                            class="mt-2"
                        />
                    </div>

                    <!-- Role -->
                    <div
                        v-if="availableRoles.length > 0"
                        class="col-span-6 lg:col-span-4"
                    >
                        <InputLabel
                            for="roles"
                            :value="$t('Role')"
                        />
                        <InputError
                            :message="addCampaignMemberForm.errors.role"
                            class="mt-2"
                        />

                        <div class="relative z-0 mt-1 border border-gray-200 dark:border-gray-700 rounded-lg cursor-pointer">
                            <button
                                v-for="(role, i) in availableRoles"
                                :key="role.key"
                                type="button"
                                class="relative px-4 py-3 inline-flex w-full rounded-lg focus:z-10 focus:outline-none focus:border-primary-500 dark:focus:border-primary-600 focus:ring-2 focus:ring-primary-500 dark:focus:ring-primary-600"
                                :class="{'border-t border-gray-200 dark:border-gray-700 focus:border-none rounded-t-none': i > 0, 'rounded-b-none': i != Object.keys(availableRoles).length - 1}"
                                @click="addCampaignMemberForm.role = role.key"
                            >
                                <div :class="{'opacity-50': addCampaignMemberForm.role && addCampaignMemberForm.role != role.key}">
                                    <!-- Role Name -->
                                    <div class="flex items-center">
                                        <div
                                            class="text-sm text-gray-600 dark:text-gray-400"
                                            :class="{'font-semibold': addCampaignMemberForm.role == role.key}"
                                        >
                                            {{ role.name }}
                                        </div>

                                        <svg
                                            v-if="addCampaignMemberForm.role == role.key"
                                            class="ml-2 h-5 w-5 text-green-400"
                                            xmlns="http://www.w3.org/2000/svg"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke-width="1.5"
                                            stroke="currentColor"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                                            />
                                        </svg>
                                    </div>

                                    <!-- Role Description -->
                                    <div class="mt-2 text-xs text-gray-600 dark:text-gray-400 text-left">
                                        {{ role.description }}
                                    </div>
                                </div>
                            </button>
                        </div>
                    </div>
                </template>

                <template #actions>
                    <ActionMessage
                        :on="addCampaignMemberForm.recentlySuccessful"
                        class="mr-3"
                    >
                        {{ $t('Added.') }}
                    </ActionMessage>

                    <PrimaryButton
                        :class="{ 'opacity-25': addCampaignMemberForm.processing }"
                        :disabled="addCampaignMemberForm.processing"
                    >
                        {{ $t('Add') }}
                    </PrimaryButton>
                </template>
            </FormSection>
        </div>

        <div v-if="campaign.campaign_invitations.length > 0 && userPermissions.canAddCampaignMembers">
            <SectionBorder />

            <!-- Campaign Member Invitations -->
            <ActionSection class="mt-10 sm:mt-0">
                <template #title>
                    {{ $t('Pending Campaign Invitations') }}
                </template>

                <template #description>
                    {{ $t('These people have been invited to your campaign and have been sent an invitation email. They may join the campaign by accepting the email invitation.') }}
                </template>

                <!-- Pending Campaign Member Invitation List -->
                <template #content>
                    <div class="space-y-6">
                        <div
                            v-for="invitation in campaign.campaign_invitations"
                            :key="invitation.id"
                            class="flex items-center justify-between"
                        >
                            <div class="text-gray-600 dark:text-gray-400">
                                {{ invitation.email }}
                            </div>

                            <div class="flex items-center">
                                <!-- Cancel Campaign Invitation -->
                                <button
                                    v-if="userPermissions.canRemoveCampaignMembers"
                                    class="cursor-pointer ml-6 text-sm text-red-500 focus:outline-none"
                                    @click="cancelCampaignInvitation(invitation)"
                                >
                                    {{ $t('Cancel') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </template>
            </ActionSection>
        </div>

        <!-- Role Management Modal -->
        <DialogModal
            :show="currentlyManagingRole"
            @close="currentlyManagingRole = false"
        >
            <template #title>
                {{ $t('Manage Role') }}
            </template>

            <template #content>
                <div v-if="managingRoleFor">
                    <div class="relative z-0 mt-1 border border-gray-200 dark:border-gray-700 rounded-lg cursor-pointer">
                        <button
                            v-for="(role, i) in availableRoles"
                            :key="role.key"
                            type="button"
                            class="relative px-4 py-3 inline-flex w-full rounded-lg focus:z-10 focus:outline-none focus:border-primary-500 dark:focus:border-primary-600 focus:ring-2 focus:ring-primary-500 dark:focus:ring-primary-600"
                            :class="{'border-t border-gray-200 dark:border-gray-700 focus:border-none rounded-t-none': i > 0, 'rounded-b-none': i !== Object.keys(availableRoles).length - 1}"
                            @click="updateRoleForm.role = role.key"
                        >
                            <div :class="{'opacity-50': updateRoleForm.role && updateRoleForm.role !== role.key}">
                                <!-- Role Name -->
                                <div class="flex items-center">
                                    <div
                                        class="text-sm text-gray-600 dark:text-gray-400"
                                        :class="{'font-semibold': updateRoleForm.role === role.key}"
                                    >
                                        {{ role.name }}
                                    </div>

                                    <svg
                                        v-if="updateRoleForm.role == role.key"
                                        class="ml-2 h-5 w-5 text-green-400"
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke-width="1.5"
                                        stroke="currentColor"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                                        />
                                    </svg>
                                </div>

                                <!-- Role Description -->
                                <div class="mt-2 text-xs text-gray-600 dark:text-gray-400">
                                    {{ role.description }}
                                </div>
                            </div>
                        </button>
                    </div>
                </div>
            </template>

            <template #footer>
                <SecondaryButton @click="currentlyManagingRole = false">
                    {{ $t('Cancel') }}
                </SecondaryButton>

                <PrimaryButton
                    class="ml-3"
                    :class="{ 'opacity-25': updateRoleForm.processing }"
                    :disabled="updateRoleForm.processing"
                    @click="updateRole"
                >
                    {{ $t('Save') }}
                </PrimaryButton>
            </template>
        </DialogModal>

        <!-- Leave Campaign Confirmation Modal -->
        <ConfirmationModal
            :show="confirmingLeavingCampaign"
            @close="confirmingLeavingCampaign = false"
        >
            <template #title>
                {{ $t('Leave Campaign') }}
            </template>

            <template #content>
                {{ $t('Are you sure you would like to leave this campaign?') }}
            </template>

            <template #footer>
                <SecondaryButton @click="confirmingLeavingCampaign = false">
                    {{ $t('Cancel') }}
                </SecondaryButton>

                <DangerButton
                    class="ml-3"
                    :class="{ 'opacity-25': leaveCampaignForm.processing }"
                    :disabled="leaveCampaignForm.processing"
                    @click="leaveCampaign"
                >
                    {{ $t('Leave') }}
                </DangerButton>
            </template>
        </ConfirmationModal>

        <!-- Remove Campaign Member Confirmation Modal -->
        <ConfirmationModal
            :show="campaignMemberBeingRemoved"
            @close="campaignMemberBeingRemoved = null"
        >
            <template #title>
                {{ $t('Remove Campaign Member') }}
            </template>

            <template #content>
                {{ $t('Are you sure you would like to remove this person from the campaign?') }}
            </template>

            <template #footer>
                <SecondaryButton @click="campaignMemberBeingRemoved = null">
                    {{ $t('Cancel') }}
                </SecondaryButton>

                <DangerButton
                    class="ml-3"
                    :class="{ 'opacity-25': removeCampaignMemberForm.processing }"
                    :disabled="removeCampaignMemberForm.processing"
                    @click="removeCampaignMember"
                >
                    {{ $t('Remove') }}
                </DangerButton>
            </template>
        </ConfirmationModal>
    </div>
</template>
