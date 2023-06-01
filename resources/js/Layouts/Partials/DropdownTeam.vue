<script setup>
import DropdownLink from "@/Components/DropdownLink.vue";
</script>

<template>
    <!-- Team Management -->
    <template v-if="$page.props.jetstream.hasTeamFeatures">
        <div class="block px-4 py-2 text-xs text-gray-400">
            {{ $t('Manage Team') }}
        </div>

        <!-- Team Settings -->
        <DropdownLink :href="route('teams.show', $page.props.auth.user.current_team)">
            {{ $t('Team Settings') }}
        </DropdownLink>

        <DropdownLink
            v-if="$page.props.jetstream.canCreateTeams"
            :href="route('teams.create')"
        >
            {{ $t('Create New Team') }}
        </DropdownLink>

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
                    <DropdownLink as="button">
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
                    </DropdownLink>
                </form>
            </template>
        </template>
    </template>
</template>

<style scoped>

</style>
