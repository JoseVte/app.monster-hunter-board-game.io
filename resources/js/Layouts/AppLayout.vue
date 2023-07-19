<script setup>
import _ from 'lodash';
import {computed, ref} from 'vue';
import {Head, Link, router, usePage} from '@inertiajs/vue3';
import {useI18n} from "vue-i18n";
import ApplicationMark from '@/Components/ApplicationMark.vue';
import Banner from '@/Components/Banner.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import GlobalSearch from "@/Components/GlobalSearch.vue";
import enImg from '~/icons/en.svg';
import esImg from '~/icons/es.svg';
import DropdownCampaign from "@/Layouts/Partials/DropdownCampaign.vue";
import DropdownTeam from "@/Layouts/Partials/DropdownTeam.vue";
import HunterBanner from "@/Layouts/Partials/HunterBanner.vue";
import ButtonDark from "@/Layouts/Partials/ButtonDark.vue";
const { locale } = useI18n({ useScope: 'global' })

locale.value = usePage().props.locale;

defineProps({
    title: String,
});

const localeImg = computed(() => {
    if (locale.value === 'en') {
        return enImg;
    }
    if (locale.value === 'es') {
        return esImg;
    }
    return enImg;
})

const showingNavigationDropdown = ref(false);
const currentTeam = usePage().props.auth.user.current_team;

const campaigns = computed(() => {
    let campaigns = [];
    if (currentTeam) {
        _.each(currentTeam.campaigns, (campaign) => {
            if (_.filter(usePage().props.auth.user.campaigns, {'id': campaign.id}).length) {
                campaigns.push(campaign)
            }
        });
    }

    return campaigns;
});

const switchToTeam = (team) => {
    router.put(route('current-team.update'), {
        team_id: team.id,
    }, {
        preserveState: false,
    });
};

const logout = () => {
    router.post(route('logout'));
};
</script>

<template>
    <div>
        <Head :title="title" />

        <Banner />

        <div class="min-h-screen">
            <nav class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
                <!-- Primary Navigation Menu -->
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <!-- Logo -->
                            <div class="shrink-0 flex items-center">
                                <Link :href="route('dashboard')">
                                    <ApplicationMark class="block h-9 w-auto text-black dark:text-white" />
                                </Link>
                            </div>

                            <!-- Navigation Links -->
                            <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                                <NavLink
                                    :href="route('dashboard')"
                                    :active="route().current('dashboard')"
                                >
                                    {{ $t('Dashboard') }}
                                </NavLink>
                            </div>

                            <!-- Search -->
                            <GlobalSearch />

                            <!-- Navigation Links -->
                            <div class="hidden space-x-8 sm:-my-px sm:flex px-4">
                                <NavLink
                                    :href="route('wiki.index')"
                                    :active="route().current('wiki.*')"
                                >
                                    {{ $t('Wiki') }}
                                </NavLink>
                            </div>
                        </div>

                        <div class="flex items-center">
                            <div class="flex items-center">
                                <div class="ml-3 relative">
                                    <ButtonDark />
                                </div>
                            </div>
                            <div class="flex items-center">
                                <div class="ml-3 relative">
                                    <!-- Locale Dropdown -->
                                    <Dropdown
                                        align="right"
                                        width="auto"
                                    >
                                        <template #trigger>
                                            <span class="inline-flex rounded-md">
                                                <button
                                                    id="locale-dropdown-btn"
                                                    type="button"
                                                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none focus:bg-gray-50 dark:focus:bg-gray-700 active:bg-gray-50 dark:active:bg-gray-700 transition ease-in-out duration-150"
                                                >
                                                    <img
                                                        class="w-4 h-4"
                                                        :src="localeImg"
                                                        alt="Locale flag"
                                                    >

                                                    <svg
                                                        class="ml-2 -mr-0.5 h-4 w-4"
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        fill="none"
                                                        viewBox="0 0 24 24"
                                                        stroke-width="1.5"
                                                        stroke="currentColor"
                                                    >
                                                        <path
                                                            stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9"
                                                        />
                                                    </svg>
                                                </button>
                                            </span>
                                        </template>

                                        <template #content>
                                            <div class="w-20 sm:w-36">
                                                <!-- Locale Switcher -->
                                                <DropdownLink :href="route('language', 'en')">
                                                    <div class="flex items-center gap-2">
                                                        <img
                                                            class="w-4 h-4"
                                                            :src="enImg"
                                                            alt="Locale flag"
                                                        >

                                                        <div class="hidden sm:block">
                                                            {{ $t('English') }}
                                                        </div>

                                                        <svg
                                                            v-if="'en' === locale"
                                                            class="h-5 w-5 text-green-400"
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
                                                </DropdownLink>
                                                <DropdownLink :href="route('language', 'es')">
                                                    <div class="flex items-center gap-2">
                                                        <img
                                                            class="w-4 h-4"
                                                            :src="esImg"
                                                            alt="Locale flag"
                                                        >

                                                        <div class="hidden sm:block">
                                                            {{ $t('Spanish') }}
                                                        </div>

                                                        <svg
                                                            v-if="'es' === locale"
                                                            class="h-5 w-5 text-green-400"
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
                                                </DropdownLink>
                                            </div>
                                        </template>
                                    </Dropdown>
                                </div>
                            </div>
                            <div class="hidden sm:flex sm:items-center sm:ml-6">
                                <div class="ml-3 relative sm:hidden lg:block">
                                    <!-- Campaign Dropdown -->
                                    <Dropdown
                                        align="right"
                                        width="60"
                                    >
                                        <template #trigger>
                                            <span class="inline-flex rounded-md">
                                                <button
                                                    id="campaign-dropdown-btn"
                                                    type="button"
                                                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none focus:bg-gray-50 dark:focus:bg-gray-700 active:bg-gray-50 dark:active:bg-gray-700 transition ease-in-out duration-150"
                                                >
                                                    {{ $page.props.current_campaign ? $page.props.current_campaign.name : $t('Campaigns') }}

                                                    <svg
                                                        class="ml-2 -mr-0.5 h-4 w-4"
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        fill="none"
                                                        viewBox="0 0 24 24"
                                                        stroke-width="1.5"
                                                        stroke="currentColor"
                                                    >
                                                        <path
                                                            stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9"
                                                        />
                                                    </svg>
                                                </button>
                                            </span>
                                        </template>

                                        <template #content>
                                            <div class="w-60">
                                                <DropdownCampaign :campaigns="campaigns" />
                                            </div>
                                        </template>
                                    </Dropdown>
                                </div>

                                <div class="ml-3 relative sm:hidden lg:block">
                                    <!-- Teams Dropdown -->
                                    <Dropdown
                                        v-if="$page.props.jetstream.hasTeamFeatures"
                                        align="right"
                                        width="60"
                                    >
                                        <template #trigger>
                                            <span class="inline-flex rounded-md">
                                                <button
                                                    id="team-dropdown-btn"
                                                    type="button"
                                                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none focus:bg-gray-50 dark:focus:bg-gray-700 active:bg-gray-50 dark:active:bg-gray-700 transition ease-in-out duration-150"
                                                >
                                                    {{ currentTeam.name }}

                                                    <svg
                                                        class="ml-2 -mr-0.5 h-4 w-4"
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        fill="none"
                                                        viewBox="0 0 24 24"
                                                        stroke-width="1.5"
                                                        stroke="currentColor"
                                                    >
                                                        <path
                                                            stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9"
                                                        />
                                                    </svg>
                                                </button>
                                            </span>
                                        </template>

                                        <template #content>
                                            <div class="w-60">
                                                <DropdownTeam :switch-to-team="switchToTeam" />
                                            </div>
                                        </template>
                                    </Dropdown>
                                </div>

                                <!-- Settings Dropdown -->
                                <div class="ml-3 relative">
                                    <Dropdown
                                        align="right"
                                        width="60"
                                    >
                                        <template #trigger>
                                            <button
                                                v-if="$page.props.jetstream.managesProfilePhotos"
                                                id="profile-dropdown-btn"
                                                class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition"
                                            >
                                                <img
                                                    class="h-8 w-8 rounded-full object-cover"
                                                    :src="$page.props.auth.user.profile_photo_url"
                                                    :alt="$page.props.auth.user.name"
                                                >
                                            </button>

                                            <span
                                                v-else
                                                class="inline-flex rounded-md"
                                            >
                                                <button
                                                    id="profile-dropdown-btn"
                                                    type="button"
                                                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none focus:bg-gray-50 dark:focus:bg-gray-700 active:bg-gray-50 dark:active:bg-gray-700 transition ease-in-out duration-150"
                                                >
                                                    {{ $page.props.auth.user.name }}

                                                    <svg
                                                        class="ml-2 -mr-0.5 h-4 w-4"
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        fill="none"
                                                        viewBox="0 0 24 24"
                                                        stroke-width="1.5"
                                                        stroke="currentColor"
                                                    >
                                                        <path
                                                            stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            d="M19.5 8.25l-7.5 7.5-7.5-7.5"
                                                        />
                                                    </svg>
                                                </button>
                                            </span>
                                        </template>

                                        <template #content>
                                            <div class="block lg:hidden">
                                                <DropdownCampaign :campaigns="campaigns" />
                                            </div>

                                            <div class="block lg:hidden border-t border-gray-200 dark:border-gray-600" />

                                            <div class="block lg:hidden">
                                                <DropdownTeam :switch-to-team="switchToTeam" />
                                            </div>

                                            <div class="block lg:hidden border-t border-gray-200 dark:border-gray-600" />

                                            <!-- Account Management -->
                                            <div class="block px-4 py-2 text-xs text-gray-400">
                                                {{ $t('Manage Account') }}
                                            </div>

                                            <DropdownLink :href="route('profile.show')">
                                                {{ $t('Profile') }}
                                            </DropdownLink>

                                            <DropdownLink
                                                v-if="$page.props.jetstream.hasApiFeatures"
                                                :href="route('api-tokens.index')"
                                            >
                                                {{ $t('API Tokens') }}
                                            </DropdownLink>

                                            <div class="border-t border-gray-200 dark:border-gray-600" />

                                            <!-- Authentication -->
                                            <form @submit.prevent="logout">
                                                <DropdownLink as="button">
                                                    {{ $t('Log Out') }}
                                                </DropdownLink>
                                            </form>
                                        </template>
                                    </Dropdown>
                                </div>
                            </div>

                            <!-- Hamburger -->
                            <div class="-mr-2 flex items-center sm:hidden">
                                <button
                                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out"
                                    @click="showingNavigationDropdown = ! showingNavigationDropdown"
                                >
                                    <svg
                                        class="h-6 w-6"
                                        stroke="currentColor"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            :class="{'hidden': showingNavigationDropdown, 'inline-flex': ! showingNavigationDropdown }"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M4 6h16M4 12h16M4 18h16"
                                        />
                                        <path
                                            :class="{'hidden': ! showingNavigationDropdown, 'inline-flex': showingNavigationDropdown }"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12"
                                        />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Responsive Navigation Menu -->
                <div
                    :class="{'block': showingNavigationDropdown, 'hidden': ! showingNavigationDropdown}"
                    class="sm:hidden"
                >
                    <div class="pt-2 pb-3 space-y-1">
                        <ResponsiveNavLink
                            :href="route('dashboard')"
                            :active="route().current('dashboard')"
                        >
                            {{ $t('Dashboard') }}
                        </ResponsiveNavLink>
                    </div>
                    <div class="pt-2 pb-3 space-y-1">
                        <ResponsiveNavLink
                            :href="route('wiki.index')"
                            :active="route().current('wiki.*')"
                        >
                            {{ $t('Wiki') }}
                        </ResponsiveNavLink>
                    </div>

                    <!-- Campaign Management -->
                    <div class="border-t border-gray-200 dark:border-gray-600" />

                    <div class="block px-4 py-2 text-xs text-gray-400">
                        {{ $t('Manage Campaigns') }}
                    </div>

                    <ResponsiveNavLink
                        :href="route('campaigns.create')"
                        :active="route().current('campaigns.create')"
                    >
                        {{ $t('Create New Campaign') }}
                    </ResponsiveNavLink>

                    <!-- Campaign Switcher -->
                    <template v-if="campaigns.length > 1">
                        <div class="border-t border-gray-200 dark:border-gray-600" />

                        <div class="block px-4 py-2 text-xs text-gray-400">
                            {{ $t('Switch Campaigns') }}
                        </div>

                        <template
                            v-for="campaign in campaigns"
                            :key="campaign.id"
                        >
                            <ResponsiveNavLink
                                :href="route('campaigns.show', campaign)"
                                :active="campaign.id == $page.props.current_campaign_id"
                            >
                                <div class="flex items-center">
                                    <svg
                                        v-if="campaign.id == $page.props.current_campaign_id"
                                        class="mr-2 h-5 w-5 text-green-400"
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
                                    <div>{{ campaign.name }}</div>
                                </div>
                            </ResponsiveNavLink>
                        </template>
                    </template>

                    <!-- Responsive Settings Options -->
                    <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
                        <div class="flex items-center px-4">
                            <div
                                v-if="$page.props.jetstream.managesProfilePhotos"
                                class="shrink-0 mr-3"
                            >
                                <img
                                    class="h-10 w-10 rounded-full object-cover"
                                    :src="$page.props.auth.user.profile_photo_url"
                                    :alt="$page.props.auth.user.name"
                                >
                            </div>

                            <div>
                                <div class="font-medium text-base text-gray-800 dark:text-gray-200">
                                    {{ $page.props.auth.user.name }}
                                </div>
                                <div class="font-medium text-sm text-gray-500">
                                    {{ $page.props.auth.user.email }}
                                </div>
                            </div>
                        </div>

                        <div class="mt-3 space-y-1">
                            <ResponsiveNavLink
                                :href="route('profile.show')"
                                :active="route().current('profile.show')"
                            >
                                {{ $t('Profile') }}
                            </ResponsiveNavLink>

                            <ResponsiveNavLink
                                v-if="$page.props.jetstream.hasApiFeatures"
                                :href="route('api-tokens.index')"
                                :active="route().current('api-tokens.index')"
                            >
                                {{ $t('API Tokens') }}
                            </ResponsiveNavLink>

                            <!-- Authentication -->
                            <form
                                method="POST"
                                @submit.prevent="logout"
                            >
                                <ResponsiveNavLink as="button">
                                    {{ $t('Log Out') }}
                                </ResponsiveNavLink>
                            </form>

                            <!-- Team Management -->
                            <template v-if="$page.props.jetstream.hasTeamFeatures">
                                <div class="border-t border-gray-200 dark:border-gray-600" />

                                <div class="block px-4 py-2 text-xs text-gray-400">
                                    {{ $t('Manage Team') }}
                                </div>

                                <!-- Team Settings -->
                                <ResponsiveNavLink
                                    :href="route('teams.show', currentTeam)"
                                    :active="route().current('teams.show')"
                                >
                                    {{ $t('Team Settings') }}
                                </ResponsiveNavLink>

                                <ResponsiveNavLink
                                    v-if="$page.props.jetstream.canCreateTeams"
                                    :href="route('teams.create')"
                                    :active="route().current('teams.create')"
                                >
                                    {{ $t('Create New Team') }}
                                </ResponsiveNavLink>

                                <!-- Team Switcher -->
                                <template v-if="$page.props.auth.user.all_teams.length > 1">
                                    <div class="border-t border-gray-200 dark:border-gray-600" />

                                    <div class="block px-4 py-2 text-xs text-gray-400">
                                        {{ $t('Switch Teams') }}
                                    </div>

                                    <template
                                        v-for="team in $page.props.auth.user.all_teams"
                                        :key="team.id"
                                    >
                                        <form @submit.prevent="switchToTeam(team)">
                                            <ResponsiveNavLink as="button">
                                                <div class="flex items-center">
                                                    <svg
                                                        v-if="team.id == $page.props.auth.user.current_team_id"
                                                        class="mr-2 h-5 w-5 text-green-400"
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
                                                    <div>{{ team.name }}</div>
                                                </div>
                                            </ResponsiveNavLink>
                                        </form>
                                    </template>
                                </template>
                            </template>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Heading -->
            <header
                v-if="$slots.header"
                class="bg-white dark:bg-gray-800 shadow"
            >
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <slot name="header" />
                </div>
            </header>

            <!-- Page Content -->
            <main>
                <HunterBanner />

                <slot />
            </main>
        </div>
    </div>
</template>
