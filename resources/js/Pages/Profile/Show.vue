<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import ConnectedAccountsForm from '@/Pages/Profile/Partials/ConnectedAccountsForm.vue';
import DeleteUserForm from '@/Pages/Profile/Partials/DeleteUserForm.vue';
import InvitationsForm from '@/Pages/Profile/Partials/InvitationsForm.vue';
import LogoutOtherBrowserSessionsForm from '@/Pages/Profile/Partials/LogoutOtherBrowserSessionsForm.vue';
import SectionBorder from '@/Components/SectionBorder.vue';
import SetPasswordForm from '@/Pages/Profile/Partials/SetPasswordForm.vue';
import TwoFactorAuthenticationForm from '@/Pages/Profile/Partials/TwoFactorAuthenticationForm.vue';
import UpdatePasswordForm from '@/Pages/Profile/Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from '@/Pages/Profile/Partials/UpdateProfileInformationForm.vue';
import Breadcrumb from "@/Components/Breadcrumb.vue";

defineProps({
    confirmsTwoFactorAuthentication: Boolean,
    sessions: Array,
    invitations: Array,
    invitationLimit: Number,
});
</script>

<template>
    <AppLayout :title="$t('Profile')">
        <template #header>
            <Breadcrumb
                :current-title="$t('Profile')"
                :breadcrumbs="[]"
            />
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <div v-if="$page.props.jetstream.canUpdateProfileInformation">
                    <UpdateProfileInformationForm :user="$page.props.auth.user" />

                    <SectionBorder />
                </div>

                <div v-if="$page.props.jetstream.canUpdatePassword && $page.props.socialLogin.hasPassword">
                    <UpdatePasswordForm class="mt-10 sm:mt-0" />

                    <SectionBorder />
                </div>

                <div v-else>
                    <SetPasswordForm class="mt-10 sm:mt-0" />

                    <SectionBorder />
                </div>

                <div v-if="$page.props.jetstream.canManageTwoFactorAuthentication">
                    <TwoFactorAuthenticationForm
                        :requires-confirmation="confirmsTwoFactorAuthentication"
                        class="mt-10 sm:mt-0"
                    />

                    <SectionBorder />
                </div>

                <div v-if="$page.props.socialLogin.providers.length">
                    <ConnectedAccountsForm class="mt-10 sm:mt-0" />
                </div>

                <SectionBorder />

                <InvitationsForm
                    :invitations="invitations"
                    :invitation-limit="invitationLimit"
                    class="mt-10 sm:mt-0"
                />

                <div v-if="$page.props.socialLogin.hasPassword">
                    <SectionBorder />

                    <LogoutOtherBrowserSessionsForm
                        :sessions="sessions"
                        class="mt-10 sm:mt-0"
                    />
                </div>

                <template v-if="$page.props.jetstream.hasAccountDeletionFeatures && $page.props.socialLogin.hasPassword">
                    <SectionBorder />

                    <DeleteUserForm class="mt-10 sm:mt-0" />
                </template>
            </div>
        </div>
    </AppLayout>
</template>
