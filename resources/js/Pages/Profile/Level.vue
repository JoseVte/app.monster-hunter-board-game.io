<script setup>
import _ from "lodash";
import {usePage} from "@inertiajs/vue3";
import {useStorage} from "vue3-storage";
import {ref, watch} from "vue";
import Card from "@/Components/Card.vue";
import AppLayout from '@/Layouts/AppLayout.vue';
import Breadcrumb from "@/Components/Breadcrumb.vue";
import Switch from "@/Components/Form/Switch.vue";
import SectionBorder from "@/Components/SectionBorder.vue";

defineProps({
    'achievements': Array,
})

const getUserAchievementProgress = (achievement) => {
    const userAchievement = _.find(usePage().props.user.achievements, userAchievement => userAchievement.id === achievement.id);

    return userAchievement ? userAchievement.pivot.progress : 0;
}

const levelColor = () => {
    const level = usePage().props.level.current;

    if (level >= 100) return 'text-gold';
    if (level >= 50) return 'text-silver';
    if (level >= 25) return 'text-bronze';

    return 'text-gray-600 dark:text-gray-200'
}

const storage = useStorage();
const showOnlyObtained = ref(storage.getStorageSync('show-only-obtained'));
watch(showOnlyObtained, (showOnlyObtainedValue) => storage.setStorageSync('show-only-obtained', showOnlyObtainedValue))
</script>

<template>
    <AppLayout :title="$t('Level')">
        <template #header>
            <Breadcrumb
                :current-title="$t('Level')"
                :breadcrumbs="[]"
            />
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-6 px-4 sm:py-10 sm:px-6 lg:px-8">
                <div class="mh-frame flex items-center gap-4 bg-white px-4 py-5 sm:p-6 dark:bg-gray-800">
                    <div
                        class="relative flex items-center justify-center bg-gray-200 dark:bg-gray-600 h-[80px] min-w-[80px] max-w-[80px] rounded-full font-bold"
                        :class="levelColor()"
                    >
                        <svg
                            height="512"
                            viewBox="0 0 64 64"
                            width="512"
                            xmlns="http://www.w3.org/2000/svg"
                            class="min-h-16 min-w-16 max-h-16 max-w-16 m-auto"
                            fill="currentColor"
                        ><g><path d="m48.87 16.18h-3.35v-4.18a.75.75 0 0 0 -.75-.75h-25.54a.75.75 0 0 0 -.75.75v4.18h-3.35a3.88 3.88 0 0 0 -3.88 3.88v4.71a8 8 0 0 0 7.34 8 13.53 13.53 0 0 0 12.66 11.74v6.74h-8.64a.75.75 0 0 0 0 1.5h18.78a.75.75 0 0 0 0-1.5h-8.64v-6.74a13.53 13.53 0 0 0 12.66-11.79 8 8 0 0 0 7.34-7.95v-4.71a3.88 3.88 0 0 0 -3.88-3.88zm-30.39 15a6.5 6.5 0 0 1 -5.73-6.44v-4.68a2.39 2.39 0 0 1 2.38-2.38h3.35zm13.52 11.87a12 12 0 0 1 -12-12.05v-18.25h24v18.25a12 12 0 0 1 -12 12.05zm19.25-18.28a6.5 6.5 0 0 1 -5.73 6.44v-13.53h3.35a2.39 2.39 0 0 1 2.38 2.38z" /><path d="m32 60.75a28.75 28.75 0 1 1 28.75-28.75 28.79 28.79 0 0 1 -28.75 28.75zm0-56a27.25 27.25 0 1 0 27.25 27.25 27.28 27.28 0 0 0 -27.25-27.25z" /></g></svg>
                        <span class="absolute top-[23px] font-montserrat text-center inset-x-0">{{ $page.props.level.current }}</span>
                    </div>
                    <div class="w-full">
                        <div class="w-full flex justify-between text-xs text-gray-700 dark:text-gray-300">
                            <span>
                                <strong>{{ $t('Points until next level') }}</strong> {{ $page.props.level.points }}<strong>/{{ $page.props.level.next + $page.props.level.points }}</strong>
                            </span>

                            {{ $page.props.level.next_percentage }}%
                        </div>
                        <div class="rounded-full w-full bg-gray-200 dark:bg-gray-600 mt-2">
                            <div
                                class="rounded-full bg-primary-500 p-1.5 text-center text-xs leading-none font-medium text-gray-100"
                                :style="`width: ${$page.props.level.next_percentage}%`"
                            />
                        </div>
                    </div>
                </div>

                <SectionBorder>
                    <Switch
                        v-model:checked="showOnlyObtained"
                        :label="$t('Show only obtained')"
                    />
                </SectionBorder>

                <div class="grid sm:grid-cols-2 md:grid-cols-3 gap-4">
                    <template
                        v-for="achievement in achievements"
                        :key="achievement.id"
                    >
                        <Card
                            v-if="!(showOnlyObtained && getUserAchievementProgress(achievement) !== 100)"
                            class="w-full justify-center gap-4 p-4 sm:p-5"
                            :owned="getUserAchievementProgress(achievement) === 100"
                        >
                            <div class="flex justify-between items-center gap-4">
                                <div class="flex items-center gap-4">
                                    <div
                                        class="achievement-container"
                                        :style="`color: ${achievement.color}; opacity: ${getUserAchievementProgress(achievement) === 100 ? 100 : 50}%`"
                                        v-html="achievement.image"
                                    />
                                    <span class="text-gray-700 dark:text-gray-300">{{ $t(achievement.name) }}</span>
                                </div>
                                <div
                                    v-if="achievement.has_progress"
                                    class="text-xs text-gray-700 dark:text-gray-300"
                                >
                                    {{ getUserAchievementProgress(achievement) }}%
                                </div>
                            </div>
                            <div
                                v-if="achievement.has_progress"
                                class="rounded-full w-full bg-gray-200 dark:bg-gray-600 mt-2"
                            >
                                <div
                                    class="rounded-full bg-primary-500 p-1 text-center text-xs leading-none font-medium text-gray-100"
                                    :style="`width: ${getUserAchievementProgress(achievement)}%`"
                                />
                            </div>
                        </Card>
                    </template>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<style>
@reference "../../../css/app.css";

.achievement-container {
    @apply text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-900 rounded-full w-10 h-10 flex items-center justify-center;
}

.achievement-container svg {
    @apply w-8 h-8 fill-current;
}
</style>
