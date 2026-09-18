<script setup>
import { ref, computed } from 'vue';
import { useI18n } from 'vue-i18n';
import { Link } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import Breadcrumb from '@/Components/Breadcrumb.vue';
import MonstersIcon from '@/Components/Icons/MonstersIcon.vue';
import Card from '@/Components/Card.vue';
import MonsterResistances from '@/Components/MonsterResistances.vue';
import TableBase from '@/Components/Table/TableBase.vue';
import Row from '@/Components/Table/Row.vue';
import CellHeader from '@/Components/Table/CellHeader.vue';
import Cell from '@/Components/Table/Cell.vue';
import { replaceIcons } from '@/icons';

const props = defineProps({
    monster: Object,
});

const { t } = useI18n();

const activeTierId = ref(props.monster.difficulties[0]?.id ?? null);
const tier = computed(() => props.monster.difficulties.find((candidate) => candidate.id === activeTierId.value));

// No artwork exists for the direction a body part faces, so it falls back to a
// plain arrow rather than a missing icon. A combined direction combines the
// individual glyphs of the directions it faces.
const DIRECTIONS = {
    up: '↑',
    down: '↓',
    left: '←',
    right: '→',
    'left-right': '↔',
    'left-right-down': '↔↓',
    'up-left-right': '↑↔',
};

// A body part's name is stored in the seed data by its English key, so it is
// translated here rather than on the way in.
const PART_NAMES = {
    head: () => t('Head'),
    back: () => t('Back'),
    claw: () => t('Claw'),
    tail: () => t('Tail'),
    leg: () => t('Leg'),
    wing: () => t('Wing'),
    paw: () => t('Paw'),
};
</script>

<template>
    <AppLayout :title="monster.name + ' | ' + $t('Monster')">
        <template #header>
            <Breadcrumb
                :current-title="monster.name"
                :breadcrumbs="[
                    { url: route('wiki.index'), title: $t('Wiki') },
                    { url: route('wiki.monster.index'), title: $t('Monsters'), icon: MonstersIcon },
                ]"
            />
        </template>

        <div class="py-6 sm:py-12">
            <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
                <Card class="gap-3 p-5">
                    <div class="flex items-center gap-3">
                        <span class="flex h-10 w-10 min-h-10 min-w-10 items-center justify-center overflow-hidden rounded-full bg-gray-300 dark:bg-gray-900">
                            <img
                                :src="monster.icon_url"
                                :alt="monster.name"
                                class="h-8 w-8 object-contain"
                            >
                        </span>
                        <span class="mh-card-name flex-1 text-xl">{{ monster.name }}</span>
                        <span class="mh-value">{{ monster.category }}</span>
                        <span class="mh-value">{{ monster.expansion }}</span>
                    </div>

                    <div class="mh-rule" />

                    <div
                        v-if="monster.difficulties.length > 1"
                        class="flex gap-2"
                    >
                        <button
                            v-for="difficultyTier in monster.difficulties"
                            :key="difficultyTier.id"
                            type="button"
                            class="rounded px-2 py-1 text-xs font-semibold uppercase tracking-wide"
                            :class="difficultyTier.id === activeTierId
                                ? 'bg-primary-500 text-white'
                                : 'bg-gray-200 text-gray-600 dark:bg-gray-900 dark:text-gray-400'"
                            @click="activeTierId = difficultyTier.id"
                        >
                            {{ difficultyTier.difficulty }}
                        </button>
                    </div>

                    <template v-if="tier">
                        <div class="flex items-center gap-3 text-sm">
                            <span class="mh-value">★ {{ tier.stars }}</span>
                            <span class="mh-value">♥ {{ tier.health }}</span>
                        </div>

                        <div class="text-sm italic">
                            <p class="font-semibold not-italic">
                                {{ tier.ability_name }}
                            </p>
                            <p v-html="replaceIcons(tier.ability_description)" />
                        </div>

                        <div
                            v-for="part in tier.parts"
                            :key="part.id"
                            class="border-t border-gray-200 pt-2 text-sm dark:border-gray-700"
                        >
                            <div class="flex items-center gap-3">
                                <span class="font-semibold">{{ PART_NAMES[part.icon]?.() ?? part.icon }} {{ DIRECTIONS[part.direction] ?? '' }}</span>
                                <span v-html="replaceIcons(`:defense_icon: ${part.defense} :break_icon: ${part.broken}`)" />
                            </div>
                            <p
                                v-if="part.ability_broken"
                                v-html="replaceIcons(part.ability_broken)"
                            />
                        </div>
                    </template>

                    <div class="mh-rule mt-2" />

                    <h3 class="mh-heading text-xs tracking-widest uppercase">
                        {{ $t('Resistances') }}
                    </h3>
                    <MonsterResistances :monster="monster" />
                </Card>

                <Card
                    v-if="monster.setup || monster.mechanics.length"
                    class="mt-4 gap-3 p-5"
                >
                    <template v-if="monster.setup">
                        <h3 class="mh-heading text-xs tracking-widest uppercase">
                            {{ $t('Setup') }}
                        </h3>
                        <p v-html="replaceIcons(monster.setup)" />
                    </template>

                    <template
                        v-for="(section, sectionIndex) in monster.mechanics"
                        :key="section.title"
                    >
                        <div
                            v-if="monster.setup || sectionIndex > 0"
                            class="mh-rule mt-2"
                        />
                        <h3 class="mh-heading text-xs tracking-widest uppercase">
                            {{ section.title }}
                        </h3>
                        <div
                            v-for="(item, itemIndex) in section.description"
                            :key="itemIndex"
                            class="text-sm"
                        >
                            <p
                                v-if="item.title"
                                class="font-semibold"
                            >
                                {{ item.title }}
                            </p>
                            <p v-html="replaceIcons(item.description)" />
                        </div>
                    </template>
                </Card>

                <Card class="mt-4 gap-3 p-5">
                    <h3 class="mh-heading text-xs tracking-widest uppercase">
                        {{ $t('Reward Table') }}
                    </h3>

                    <TableBase>
                        <template #header>
                            <CellHeader>{{ $t('Number Rolled') }}</CellHeader>
                            <CellHeader>{{ $t('Item') }}</CellHeader>
                            <CellHeader>{{ $t('Part Break Rewards') }}</CellHeader>
                        </template>

                        <Row
                            v-for="reward in monster.rewards"
                            :key="reward.id"
                        >
                            <Cell>{{ reward.roll }}</Cell>
                            <Cell>
                                <Link
                                    :href="route('wiki.item.show', reward.item.id)"
                                    class="text-gray-900 underline dark:text-parchment"
                                >
                                    {{ reward.item.name }}
                                </Link>
                            </Cell>
                            <Cell>
                                <span v-html="replaceIcons(reward.extra ?? '')" />
                            </Cell>
                        </Row>
                    </TableBase>
                </Card>
            </div>
        </div>
    </AppLayout>
</template>
