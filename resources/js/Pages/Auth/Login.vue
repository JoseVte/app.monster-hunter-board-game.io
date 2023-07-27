<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import {useReCaptcha} from "vue-recaptcha-v3";
import {onUnmounted} from "vue";
import AuthenticationCard from '@/Components/AuthenticationCard.vue';
import AuthenticationCardLogo from '@/Components/AuthenticationCardLogo.vue';
import Checkbox from '@/Components/Form/Checkbox.vue';
import InputError from '@/Components/Form/InputError.vue';
import InputLabel from '@/Components/Form/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import Socialstream from '@/Components/Socialstream.vue';
import TextInput from '@/Components/Form/TextInput.vue';

defineProps({
    canResetPassword: Boolean,
    status: String,
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
    captcha_token: null,
});
const { executeRecaptcha, recaptchaLoaded, instance } = useReCaptcha()
recaptchaLoaded().then(() => {
    if (instance?.value) {
        instance.value.showBadge()
    }
})

onUnmounted(() => {
    if (instance?.value) {
        instance.value.hideBadge()
    }
})

const submit = async () => {
    form.captcha_token = await executeRecaptcha('login')

    form.transform(data => ({
        ...data,
        remember: form.remember ? 'on' : '',
    })).post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <Head :title="$t('Log in')" />

    <AuthenticationCard :can-register="true">
        <template #logo>
            <AuthenticationCardLogo />
        </template>

        <div
            v-if="status"
            class="mb-4 font-medium text-sm text-green-600"
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
                    autofocus
                />
                <InputError
                    class="mt-2"
                    :message="form.errors.email"
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
                    autocomplete="current-password"
                />
                <InputError
                    class="mt-2"
                    :message="form.errors.password"
                />
            </div>

            <div class="block mt-4">
                <label class="flex items-center">
                    <Checkbox
                        v-model:checked="form.remember"
                        name="remember"
                    />
                    <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">{{ $t('Remember me') }}</span>
                </label>

                <InputError
                    class="mt-2"
                    :message="form.errors.captcha_token"
                />
            </div>

            <div class="flex items-center justify-end mt-4">
                <Link
                    v-if="canResetPassword"
                    :href="route('password.request')"
                    class="underline text-sm text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-100"
                >
                    {{ $t('Forgot your password?') }}
                </Link>

                <PrimaryButton
                    class="ml-4"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    {{ $t('Log in') }}
                </PrimaryButton>
            </div>
        </form>

        <Socialstream v-if="$page.props.socialstream.show" />
    </AuthenticationCard>
</template>
