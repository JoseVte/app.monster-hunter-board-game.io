<script setup lang="ts">
import {h, type Component} from "vue";
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

// `Armor::items()` `withPivot('number')`, so every entry sent through it
// carries a `pivot.number` the generated `Item` type does not declare (a
// `belongsToMany` pivot is not part of the model's own columns). This is
// *not* `Pick<App.Models.Pivot.CountItemArmor, 'number'>`: that generated
// type describes the pivot *table* row (`id`, both foreign keys, both
// timestamps), and `withPivot('number')` only ever adds `number` on top of
// the relation's own two foreign keys (`armor_id`, `item_id`), never `id`.
// So `armor.items[].pivot` at runtime is
// `{armor_id, item_id, number, created_at, updated_at}`, no `id`. Declared
// as the one field this page actually reads, matching
// `resources/js/__tests__/fixtures.ts`'s own `{...item, pivot: {number: 2}}`,
// rather than a `Pick` off a type that does not match this shape either.
// Report: this is a `ModelShape` gap, not a controller-composed prop.
type ItemWithPivot = App.Models.Item & {pivot: {number: number}};

type ArmorDetail = Omit<App.Models.Armor, 'items'> & {
    items?: ItemWithPivot[];
};

type MissingItem = {name: string; missing: number};

// `ArmorController::hunters()`'s own shape; no model backs it, and it is
// declared again here (rather than imported from `CraftWithHunter.vue`,
// which has no exports) because the brief's rule is to declare these locally
// per page.
type ArmorCraftableHunter = {
    id: number;
    name: string;
    campaign: string;
    campaign_id: number;
    can_craft: boolean;
    owned: boolean;
    missing: MissingItem[];
};

const props = withDefaults(defineProps<{
    armor: ArmorDetail;
    hunters?: ArmorCraftableHunter[];
}>(), {
    hunters: () => [],
});

type ArmorTypeKey = 'head' | 'body' | 'leg';

const ICONS: Record<ArmorTypeKey, Component> = {head: HelmetIcon, body: ArmorsIcon, leg: LegArmor};

// `Armor.type_value` is a plain string off the model (an appended accessor,
// not the literal union above), so it is checked against the map's own keys
// rather than cast into it. `in` walks the prototype chain, so
// `'toString' in ICONS` is `true` and this would wrongly accept it;
// `Object.hasOwn` checks the object's own keys only. Matches
// `WeaponStats.vue`'s `isDeviationKey` guard. `type_value` is derived from
// `ArmorType`, which only ever has these three cases, so the guard always
// passes for a real armor; `ArmorsIcon` below only exists so `icon` has a
// value to hand to `h()`.
const isArmorTypeKey = (key: string | undefined): key is ArmorTypeKey => !! key && Object.hasOwn(ICONS, key);
const icon = isArmorTypeKey(props.armor.type_value) ? ICONS[props.armor.type_value] : ArmorsIcon;

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

                    <template v-if="armor.skills?.length">
                        <h3 class="mh-heading mt-2 text-xs tracking-widest uppercase">
                            {{ $t('Skill') }}
                        </h3>
                        <div
                            v-for="skill in armor.skills ?? []"
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

                    <template v-if="armor.items?.length">
                        <h3 class="mh-heading mt-2 text-xs tracking-widest uppercase">
                            {{ $t('Materials') }}
                        </h3>
                        <ul class="flex flex-col gap-1 text-sm">
                            <li
                                v-for="item in armor.items ?? []"
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
