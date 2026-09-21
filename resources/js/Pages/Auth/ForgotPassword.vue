<script setup>
import { Head, useForm, usePage } from '@inertiajs/vue3';
import { useRecaptcha } from '@/recaptcha';
import AuthenticationCard from '@/Components/AuthenticationCard.vue';
import AuthenticationCardLogo from '@/Components/AuthenticationCardLogo.vue';
import InputError from '@/Components/Form/InputError.vue';
import InputLabel from '@/Components/Form/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import RecaptchaNotice from '@/Components/RecaptchaNotice.vue';
import TextInput from '@/Components/Form/TextInput.vue';

defineProps({
    status: String,
});

const form = useForm({
    email: '',
    captcha_token: null,
});

const recaptcha = useRecaptcha(usePage().props.recaptcha_site_key);

const submit = async () => {
    form.captcha_token = await recaptcha.execute('forgot_password');

    form.post(route('password.email'));
};
</script>

<template>
    <Head :title="$t('Forgot Password')" />

    <AuthenticationCard>
        <template #logo>
            <AuthenticationCardLogo />
        </template>

        <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
            {{ $t('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
        </div>

        <div
            v-if="status"
            class="mb-4 font-medium text-sm text-green-600 dark:text-green-400"
        >
            {{ status }}
        </div>

        <form @submit.prevent="submit">
            <div>
                <InputLabel
                    for="email"
                    :value="$t('Email')"
                />
                <TextInput
                    id="email"
                    v-model="form.email"
                    type="email"
                    class="mt-1 block w-full"
                    required
                    autofocus
                    autocomplete="username"
                />
                <InputError
                    class="mt-2"
                    :message="form.errors.email"
                />
            </div>

            <div class="flex items-center justify-end mt-4">
                <InputError
                    class="mt-2"
                    :message="form.errors.captcha_token"
                />

                <PrimaryButton
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    {{ $t('Email Password Reset Link') }}
                </PrimaryButton>
            </div>

            <RecaptchaNotice />
        </form>
    </AuthenticationCard>
</template>
