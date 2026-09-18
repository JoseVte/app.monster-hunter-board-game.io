<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthenticationCard from '@/Components/AuthenticationCard.vue';
import AuthenticationCardLogo from '@/Components/AuthenticationCardLogo.vue';
import InputError from '@/Components/Form/InputError.vue';
import InputLabel from '@/Components/Form/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/Form/TextInput.vue';

const props = defineProps({
    invitation: Number,
    signature: String,
    email: String,
    campaign: String,
});

const form = useForm({
    name: '',
    password: '',
    password_confirmation: '',
});

// Posted back to the very URL that was opened. A signature covers the address
// and its query, not the method, so it guards the account creation too.
const submit = () => {
    form.post(props.signature, {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <Head :title="$t('Accept Invitation')" />

    <AuthenticationCard>
        <template #logo>
            <AuthenticationCardLogo />
        </template>

        <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
            {{ $t('You have been invited to the campaign') }}
            <span class="font-semibold">{{ props.campaign }}</span>.
            {{ $t('Create your account to accept.') }}
        </div>

        <form @submit.prevent="submit">
            <div>
                <InputLabel
                    for="name"
                    :value="$t('Name')"
                />
                <TextInput
                    id="name"
                    v-model="form.name"
                    type="text"
                    class="mt-1 block w-full"
                    autofocus
                    autocomplete="name"
                />
                <InputError
                    class="mt-2"
                    :message="form.errors.name"
                />
            </div>

            <div class="mt-4">
                <InputLabel
                    for="email"
                    :value="$t('Email')"
                />
                <TextInput
                    id="email"
                    :model-value="props.email"
                    type="email"
                    class="mt-1 block w-full"
                    readonly
                />
            </div>

            <div class="mt-4">
                <InputLabel
                    for="password"
                    :value="$t('Password')"
                />
                <TextInput
                    id="password"
                    v-model="form.password"
                    type="password"
                    class="mt-1 block w-full"
                    autocomplete="new-password"
                />
                <InputError
                    class="mt-2"
                    :message="form.errors.password"
                />
            </div>

            <div class="mt-4">
                <InputLabel
                    for="password_confirmation"
                    :value="$t('Confirm Password')"
                />
                <TextInput
                    id="password_confirmation"
                    v-model="form.password_confirmation"
                    type="password"
                    class="mt-1 block w-full"
                    autocomplete="new-password"
                />
                <InputError
                    class="mt-2"
                    :message="form.errors.password_confirmation"
                />
            </div>

            <div class="flex items-center justify-end mt-4">
                <Link
                    :href="route('login')"
                    class="underline text-sm text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-100"
                >
                    {{ $t('Already registered?') }}
                </Link>

                <PrimaryButton
                    class="ml-4"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    {{ $t('Accept Invitation') }}
                </PrimaryButton>
            </div>
        </form>
    </AuthenticationCard>
</template>
