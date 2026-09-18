<script setup>
import { computed } from 'vue';
import { useForm } from '@inertiajs/vue3';
import ActionSection from '@/Components/ActionSection.vue';
import DangerButton from '@/Components/DangerButton.vue';
import InputError from '@/Components/Form/InputError.vue';
import InputLabel from '@/Components/Form/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/Form/TextInput.vue';

const props = defineProps({
    invitations: {
        type: Array,
        default: () => [],
    },
    invitationLimit: {
        type: Number,
        default: 0,
    },
});

const badges = {
    pending: 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300',
    accepted: 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300',
    revoked: 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300',
    expired: 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300',
};

const pendingCount = computed(() => props.invitations.filter((invitation) => invitation.status === 'pending').length);
const remaining = computed(() => Math.max(0, props.invitationLimit - pendingCount.value));

const createForm = useForm({ email: '' });
const actionForm = useForm({});

const invite = () => createForm.post(route('invitations.store'), {
    preserveScroll: true,
    onSuccess: () => createForm.reset('email'),
});

const resend = (invitation) => actionForm.put(route('invitations.resend', invitation.id), {
    preserveScroll: true,
});

const revoke = (invitation) => actionForm.delete(route('invitations.destroy', invitation.id), {
    preserveScroll: true,
});
</script>

<template>
    <ActionSection>
        <template #title>
            {{ $t('Invitations') }}
        </template>

        <template #description>
            {{ $t('Registration is by invitation. Invite someone by email, or leave it blank to get a link you can share yourself.') }}
        </template>

        <template #content>
            <div class="text-sm text-gray-600 dark:text-gray-400">
                {{ $t('Invitations left') }}: {{ remaining }}
            </div>

            <form
                class="mt-4 sm:flex sm:items-end sm:gap-3"
                @submit.prevent="invite"
            >
                <div class="flex-1">
                    <InputLabel
                        for="invitation_email"
                        :value="$t('Email')"
                    />
                    <TextInput
                        id="invitation_email"
                        v-model="createForm.email"
                        type="email"
                        class="mt-1 block w-full"
                        :placeholder="$t('Optional')"
                    />
                    <InputError
                        class="mt-2"
                        :message="createForm.errors.email"
                    />
                </div>

                <PrimaryButton
                    class="mt-3 sm:mt-0"
                    :class="{ 'opacity-25': createForm.processing }"
                    :disabled="createForm.processing || remaining === 0"
                >
                    {{ $t('Invite') }}
                </PrimaryButton>
            </form>

            <div
                v-if="invitations.length"
                class="mt-6 space-y-3"
            >
                <div
                    v-for="invitation in invitations"
                    :key="invitation.id"
                    class="flex items-center justify-between gap-3 border-t border-gray-200 pt-3 dark:border-gray-700"
                >
                    <div class="min-w-0">
                        <div class="truncate text-sm text-gray-800 dark:text-gray-200">
                            {{ invitation.email || $t('Shareable link') }}
                        </div>
                        <span
                            class="mt-1 inline-block rounded px-2 py-0.5 text-xs font-medium"
                            :class="badges[invitation.status]"
                        >
                            {{ $t(invitation.status) }}
                        </span>
                    </div>

                    <div
                        v-if="invitation.status === 'pending'"
                        class="flex shrink-0 gap-2"
                    >
                        <SecondaryButton
                            v-if="invitation.email"
                            :disabled="actionForm.processing"
                            @click="resend(invitation)"
                        >
                            {{ $t('Resend') }}
                        </SecondaryButton>

                        <DangerButton
                            :disabled="actionForm.processing"
                            @click="revoke(invitation)"
                        >
                            {{ $t('Revoke') }}
                        </DangerButton>
                    </div>
                </div>
            </div>
        </template>
    </ActionSection>
</template>
