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

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    terms: false,
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
    form.captcha_token = await executeRecaptcha('register')
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <Head :title="$t('Register')" />

    <AuthenticationCard>
        <template #logo>
            <AuthenticationCardLogo />
        </template>

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
                    v-model="form.email"
                    type="email"
                    class="mt-1 block w-full"
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

            <div
                v-if="$page.props.jetstream.hasTermsAndPrivacyPolicyFeature"
                class="mt-4"
            >
                <InputLabel for="terms">
                    <div class="flex items-center">
                        <Checkbox
                            id="terms"
                            v-model:checked="form.terms"
                            name="terms"
                        />

                        <div
                            class="ml-2"
                            v-html="$page.props.jetstreamAcceptText"
                        />
                    </div>
                </InputLabel>
            </div>

            <InputError
                class="mt-2"
                :message="form.errors.captcha_token"
            />

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
                    {{ $t('Register') }}
                </PrimaryButton>
            </div>
        </form>

        <Socialstream v-if="$page.props.socialstream.show" />
    </AuthenticationCard>
</template>
