<script setup lang="ts">
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
import headImg from '~/monster-parts/head.png';
import backImg from '~/monster-parts/back.png';
import clawImg from '~/monster-parts/claw.png';
import tailImg from '~/monster-parts/tail.png';
import legImg from '~/monster-parts/leg.png';
import wingImg from '~/monster-parts/wing.png';
import pawImg from '~/monster-parts/paw.png';
import PositionMarker from '@/Components/Icons/PositionMarker.vue';
import ShieldIcon from '@/Components/Icons/ShieldIcon.vue';
import BrokenPartIcon from '@/Components/Icons/BrokenPartIcon.vue';

const props = defineProps<{
    monster: App.Models.Monster;
}>();

const { t } = useI18n();

// `difficulties` is a relation, so the generated type marks it optional even
// though the controller always loads it (`$monster->load('difficulties.parts')`)
// before rendering this page.
const activeTierId = ref<number | null>(props.monster.difficulties?.[0]?.id ?? null);
const tier = computed(() => props.monster.difficulties?.find((candidate) => candidate.id === activeTierId.value));

type PartIconKey = 'head' | 'back' | 'claw' | 'tail' | 'leg' | 'wing' | 'paw';

// A body part's name is stored in the seed data by its English key, so it is
// translated here rather than on the way in.
const PART_NAMES: Record<PartIconKey, () => string> = {
    head: () => t('Head'),
    back: () => t('Back'),
    claw: () => t('Claw'),
    tail: () => t('Tail'),
    leg: () => t('Leg'),
    wing: () => t('Wing'),
    paw: () => t('Paw'),
};

// A generic pictogram per part, original to this app rather than the
// physical card's own art (which draws one whole-body silhouette per
// monster, not a named icon per part).
const PART_ICONS: Record<PartIconKey, string> = {
    head: headImg,
    back: backImg,
    claw: clawImg,
    tail: tailImg,
    leg: legImg,
    wing: wingImg,
    paw: pawImg,
};

// `MonsterPart.icon` is a plain string off the model, not the literal union
// above, so it is checked against the maps' own keys rather than cast into
// them. `in` walks the prototype chain, so `'toString' in PART_ICONS` is
// `true` and this would wrongly accept it; `Object.hasOwn` checks the
// object's own keys only. Matches `WeaponStats.vue`'s `isDeviationKey` guard.
const isPartIconKey = (key: string): key is PartIconKey => Object.hasOwn(PART_ICONS, key);

const partName = (icon: string): string => (isPartIconKey(icon) ? PART_NAMES[icon]() : icon);
const partIcon = (icon: string): string | undefined => (isPartIconKey(icon) ? PART_ICONS[icon] : undefined);
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

                    <Link
                        :href="route('wiki.monster.card', [monster.id])"
                        class="text-sm text-gray-600 underline dark:text-parchment-dim"
                    >
                        {{ $t('View as card') }}
                    </Link>

                    <div class="mh-rule" />

                    <div
                        v-if="(monster.difficulties?.length ?? 0) > 1"
                        class="flex gap-2"
                    >
                        <button
                            v-for="difficultyTier in monster.difficulties ?? []"
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
                            v-for="part in tier.parts ?? []"
                            :key="part.id"
                            class="border-t border-gray-200 pt-2 text-sm dark:border-gray-700"
                        >
                            <div class="flex items-center gap-3">
                                <img
                                    v-if="partIcon(part.icon)"
                                    :src="partIcon(part.icon)"
                                    :alt="part.icon"
                                    class="h-8 w-8 shrink-0"
                                >
                                <span class="font-semibold">{{ partName(part.icon) }}</span>
                                <PositionMarker
                                    :direction="part.direction"
                                    class="h-10 w-10 text-gray-400 dark:text-gray-600"
                                />
                                <span class="flex items-center gap-1">
                                    <ShieldIcon class="h-10 w-10" />
                                    <span class="mh-value">{{ part.defense }}</span>
                                </span>
                                <span class="flex items-center gap-1">
                                    <BrokenPartIcon class="h-10 w-10 text-gray-500 dark:text-gray-400" />
                                    <span class="mh-value">{{ part.broken }}</span>
                                </span>
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
                    v-if="monster.setup || monster.mechanics?.length"
                    class="mt-4 gap-3 p-5"
                >
                    <template v-if="monster.setup">
                        <h3 class="mh-heading text-xs tracking-widest uppercase">
                            {{ $t('Setup') }}
                        </h3>
                        <p v-html="replaceIcons(monster.setup)" />
                    </template>

                    <template
                        v-for="(section, sectionIndex) in monster.mechanics ?? []"
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
                            v-for="reward in monster.rewards ?? []"
                            :key="reward.id"
                        >
                            <Cell>{{ reward.roll }}</Cell>
                            <Cell>
                                <Link
                                    :href="route('wiki.item.show', reward.item?.id)"
                                    class="text-gray-900 underline dark:text-parchment"
                                >
                                    {{ reward.item?.name }}
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
