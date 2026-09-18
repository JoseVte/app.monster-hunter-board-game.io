<script setup>
import {h} from "vue";
import {Link} from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import Breadcrumb from "@/Components/Breadcrumb.vue";
import ArmorsIcon from "@/Components/Icons/ArmorsIcon.vue";
import HelmetIcon from "@/Components/Icons/HelmetIcon.vue";
import LegArmor from "@/Components/Icons/LegArmor.vue";
import KnightIcon from "@/Components/Icons/KnightIcon.vue";
import Card from "@/Components/Card.vue";
import CraftWithHunter from "@/Pages/Wiki/Partials/CraftWithHunter.vue";
import ArmorDefenseRow from "@/Pages/Hunter/Partials/ArmorDefenseRow.vue";
import {getRarityColor} from "@/rarity";

const props = defineProps({
    armor: Object,
    hunters: {
        type: Array,
        default: () => [],
    },
});

const ICONS = {head: HelmetIcon, body: ArmorsIcon, leg: LegArmor};
const icon = ICONS[props.armor.type_value];

// Breadcrumb's icon slot wants a component, not a rarity to tint the slot
// icon by, so it is wrapped in one rather than shown plain.
const currentIcon = () => h(icon, {class: getRarityColor(props.armor.rarity)});
</script>

<template>
    <AppLayout :title="armor.name">
        <template #header>
            <Breadcrumb
                :current-title="armor.name"
                :breadcrumbs="[
                    { url: route('wiki.index'), title: $t('Wiki') },
                    { url: route('wiki.armor.index'), title: $t('Armors'), icon: ArmorsIcon },
                ]"
                :icon="currentIcon"
            />
        </template>

        <div class="py-6 sm:py-12">
            <div class="mx-auto max-w-2xl px-4 sm:px-6 lg:px-8">
                <!-- The piece as the component prints it: what it protects
                     against, what it grants and what it costs. -->
                <Card class="gap-3 p-5">
                    <div class="flex items-center gap-3">
                        <span class="flex h-10 w-10 min-h-10 min-w-10 items-center justify-center rounded-full bg-gray-300 dark:bg-gray-900">
                            <component
                                :is="icon"
                                class="h-5 w-5"
                                :class="getRarityColor(armor.rarity)"
                            />
                        </span>
                        <span class="mh-card-name flex-1 text-xl">{{ armor.name }}</span>
                        <Link
                            class="mh-value"
                            :class="getRarityColor(armor.rarity)"
                            :href="route('wiki.armor.index', { rarity: armor.rarity })"
                        >
                            {{ $t('Rarity') }} {{ armor.rarity }}
                        </Link>
                    </div>

                    <div class="mh-rule" />

                    <ArmorDefenseRow :armor="armor" />

                    <template v-if="armor.skills.length">
                        <h3 class="mh-heading mt-2 text-xs tracking-widest uppercase">
                            {{ $t('Skill') }}
                        </h3>
                        <div
                            v-for="skill in armor.skills"
                            :key="skill.id"
                            class="text-sm"
                        >
                            <div class="flex items-center justify-between gap-2 font-semibold">
                                <span>{{ skill.name }}</span>
                                <KnightIcon
                                    v-if="skill.bonus_set"
                                    class="h-5 w-5 shrink-0"
                                    :class="getRarityColor(armor.rarity)"
                                />
                            </div>
                            <div
                                class="mt-1 wrap-break-word text-gray-700 dark:text-gray-300"
                                v-html="replaceIcons(skill.description)"
                            />
                        </div>
                    </template>

                    <template v-if="armor.items.length">
                        <h3 class="mh-heading mt-2 text-xs tracking-widest uppercase">
                            {{ $t('Materials') }}
                        </h3>
                        <ul class="flex flex-col gap-1 text-sm">
                            <li
                                v-for="item in armor.items"
                                :key="item.id"
                                class="flex items-center justify-between gap-3"
                            >
                                <Link
                                    :href="route('wiki.item.show', [item.id])"
                                    class="text-gray-900 hover:underline dark:text-parchment"
                                >
                                    {{ item.name }}
                                </Link>
                                <span class="mh-value">{{ item.pivot.number }}</span>
                            </li>
                        </ul>
                    </template>

                    <div class="mh-rule mt-2" />

                    <dl class="flex flex-wrap gap-x-6 gap-y-1 text-sm text-gray-600 dark:text-gray-400">
                        <div
                            v-if="armor.branch"
                            class="flex gap-2"
                        >
                            <dt>{{ $t('Monster') }}</dt>
                            <dd>
                                <Link
                                    class="text-gray-900 hover:underline dark:text-parchment"
                                    :href="route('wiki.armor.index', { branch: armor.branch })"
                                >
                                    {{ armor.branch }}
                                </Link>
                            </dd>
                        </div>
                        <div
                            v-if="armor.expansion"
                            class="flex gap-2"
                        >
                            <dt>{{ $t('Expansion') }}</dt>
                            <dd>
                                <Link
                                    class="text-gray-900 hover:underline dark:text-parchment"
                                    :href="route('wiki.armor.index', { expansion: armor.expansion_value })"
                                >
                                    {{ armor.expansion }}
                                </Link>
                            </dd>
                        </div>
                    </dl>
                </Card>

                <CraftWithHunter
                    :hunters="hunters"
                    :armor="armor"
                />
            </div>
        </div>
    </AppLayout>
</template>
