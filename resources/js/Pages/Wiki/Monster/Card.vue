<script setup>
import {ref, computed} from "vue";
import {Link} from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import Breadcrumb from "@/Components/Breadcrumb.vue";
import MonstersIcon from "@/Components/Icons/MonstersIcon.vue";
import Card from "@/Components/Card.vue";
import MonsterResistances from "@/Components/MonsterResistances.vue";
import {replaceIcons} from "@/icons";
import MonsterPartBox from "@/Pages/Wiki/Monster/Partials/MonsterPartBox.vue";

const props = defineProps({
    monster: Object,
});

const activeTierId = ref(props.monster.difficulties[0]?.id ?? null);
const tier = computed(() => props.monster.difficulties.find((candidate) => candidate.id === activeTierId.value));

// The card's own layout puts the illustration in the middle with a break
// box at each corner. Own icon in the centre (absolutely positioned, so it
// never competes with a box for space), own parts split into a top and a
// bottom row of up to two, in whatever order the seed data lists them; each
// box then sizes to its own content instead of being forced to share a
// grid column's width with the box above or below it. A fifth part (some
// tiers have only three, never more than four) would have nowhere to go,
// so it falls back into the flow below instead of being lost.
const CORNER_COUNT = 4;
const cornerParts = computed(() => tier.value?.parts?.slice(0, CORNER_COUNT) ?? []);
const topParts = computed(() => cornerParts.value.slice(0, 2));
const bottomParts = computed(() => cornerParts.value.slice(2, 4));
const overflowParts = computed(() => tier.value?.parts?.slice(CORNER_COUNT) ?? []);
</script>

<template>
    <AppLayout :title="monster.name + ' | ' + $t('Card')">
        <template #header>
            <Breadcrumb
                :current-title="$t('Card')"
                :breadcrumbs="[
                    { url: route('wiki.index'), title: $t('Wiki') },
                    { url: route('wiki.monster.index'), title: $t('Monsters'), icon: MonstersIcon },
                    { url: route('wiki.monster.show', [monster.id]), title: monster.name },
                ]"
            />
        </template>

        <div class="py-6 sm:py-12">
            <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
                <Card class="mh-monster-card grid grid-cols-1 gap-4 p-5 lg:grid-cols-[minmax(0,260px)_1fr]">
                    <div class="flex flex-col gap-3">
                        <div>
                            <p class="text-xs tracking-widest text-gray-500 uppercase dark:text-parchment-dim">
                                {{ monster.category }}
                            </p>
                            <p class="mh-card-name text-xl">
                                {{ monster.name }}
                            </p>
                        </div>

                        <div
                            v-if="monster.difficulties.length > 1"
                            class="flex flex-wrap gap-2"
                        >
                            <button
                                v-for="difficultyTier in monster.difficulties"
                                :key="difficultyTier.id"
                                type="button"
                                class="rounded px-2 py-1 text-xs font-semibold tracking-wide uppercase"
                                :class="difficultyTier.id === activeTierId
                                    ? 'bg-primary-500 text-white'
                                    : 'bg-gray-200 text-gray-600 dark:bg-gray-900 dark:text-gray-400'"
                                @click="activeTierId = difficultyTier.id"
                            >
                                {{ difficultyTier.difficulty }}
                            </button>
                        </div>

                        <div
                            v-if="tier"
                            class="flex items-center gap-3 text-sm"
                        >
                            <span class="mh-value">★ {{ tier.stars }}</span>
                            <span class="mh-value">♥ {{ tier.health }}</span>
                        </div>

                        <div class="mh-rule" />

                        <MonsterResistances :monster="monster" />

                        <template v-if="tier">
                            <div class="mh-rule" />

                            <div class="text-sm italic">
                                <p class="font-semibold not-italic">
                                    {{ tier.ability_name }}
                                </p>
                                <p v-html="replaceIcons(tier.ability_description)" />
                            </div>
                        </template>
                    </div>

                    <div class="mh-monster-portrait flex min-h-64 flex-col items-center justify-center gap-4 overflow-hidden rounded-lg p-4 lg:min-h-0">
                        <!-- The physical card puts its illustration in the middle with a
                             break box at each corner; this recreates that with the
                             monster's own icon as its own row between two flex rows
                             (top parts, bottom parts) instead of a grid, so a box is
                             never squeezed to share a column's width with the icon or
                             with the box above/below it. -->
                        <div
                            v-if="cornerParts.length"
                            class="flex w-full flex-col items-center gap-3"
                        >
                            <div class="flex w-full justify-between gap-3">
                                <MonsterPartBox
                                    v-for="part in topParts"
                                    :key="part.id"
                                    :part="part"
                                />
                            </div>

                            <img
                                :src="monster.icon_url"
                                :alt="monster.name"
                                class="h-16 w-16 shrink-0 object-contain sm:h-20 sm:w-20"
                            >

                            <div class="flex w-full justify-between gap-3">
                                <MonsterPartBox
                                    v-for="part in bottomParts"
                                    :key="part.id"
                                    :part="part"
                                />
                            </div>
                        </div>

                        <img
                            v-else
                            :src="monster.icon_url"
                            :alt="monster.name"
                            class="h-16 w-16 object-contain sm:h-20 sm:w-20"
                        >

                        <div
                            v-if="overflowParts.length"
                            class="flex w-full flex-wrap justify-center gap-2"
                        >
                            <MonsterPartBox
                                v-for="part in overflowParts"
                                :key="part.id"
                                :part="part"
                            />
                        </div>
                    </div>
                </Card>

                <div class="mt-4">
                    <Link
                        :href="route('wiki.monster.show', [monster.id])"
                        class="text-sm text-gray-600 underline dark:text-parchment-dim"
                    >
                        {{ $t('Back to') }} {{ monster.name }}
                    </Link>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<style scoped>
@reference "../../../../css/app.css";

/* The card's own parchment tone, distinct from the app's usual gray panel,
   since this view recreates the physical card rather than the wiki chrome
   around it. */
.mh-monster-card {
    @apply bg-[#ece3cf] dark:bg-[#2a2418];
}

.mh-monster-portrait {
    @apply bg-[#ece3cf] dark:bg-[#2a2418];
}
</style>
