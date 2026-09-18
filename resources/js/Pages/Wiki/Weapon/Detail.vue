<script setup>
import {h} from "vue";
import {Link} from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import Breadcrumb from "@/Components/Breadcrumb.vue";
import WeaponsIcon from "@/Components/Icons/WeaponsIcon.vue";
import Card from "@/Components/Card.vue";
import WeaponTypeIcon from "@/Components/WeaponTypeIcon.vue";
import CraftWithHunter from "@/Pages/Wiki/Partials/CraftWithHunter.vue";
import {getRarityColor} from "@/rarity";
import damageAttack from '~/icons/damage-attack.png';
import comboAttack from '~/icons/combo-attack.png';
import defenseIcon from '~/icons/defense.png';

const props = defineProps({
    weapon: Object,
    hunters: {
        type: Array,
        default: () => [],
    },
});

// The stamina board a weapon fills: how many of each attack card it brings.
const attacks = [1, 2, 3, 4, 5]
    .map((slot) => ({slot, count: props.weapon[`count_attack_${slot}`]}))
    .filter(({count}) => count);

// Breadcrumb's icon slots want a component, not a URL or a rarity to tint by,
// so the type's plain icon and this weapon's own rarity-tinted one are each
// wrapped in one.
const typeIcon = () => h('img', {src: props.weapon.type?.image_url, alt: props.weapon.type?.name});
const currentIcon = () => h(WeaponTypeIcon, {weaponType: props.weapon.type, class: getRarityColor(props.weapon.rarity)});
</script>

<template>
    <AppLayout :title="weapon.name">
        <template #header>
            <Breadcrumb
                :current-title="weapon.name"
                :breadcrumbs="[
                    { url: route('wiki.index'), title: $t('Wiki') },
                    { url: route('wiki.weapon.index'), title: $t('Weapons'), icon: WeaponsIcon },
                    { url: route('wiki.weapon.type', [weapon.type_id]), title: weapon.type?.name, icon: typeIcon },
                ]"
                :icon="currentIcon"
            />
        </template>

        <div class="py-6 sm:py-12">
            <div class="mx-auto max-w-2xl px-4 sm:px-6 lg:px-8">
                <!-- The weapon as the component prints it: what it brings to the
                     stamina board, what it costs and where it sits in its line. -->
                <Card class="gap-3 p-5">
                    <div class="flex items-center gap-3">
                        <span class="flex h-10 w-10 min-h-10 min-w-10 items-center justify-center rounded-full bg-gray-300 dark:bg-gray-900">
                            <WeaponsIcon
                                class="h-5 w-5"
                                :class="getRarityColor(weapon.rarity)"
                            />
                        </span>
                        <span class="mh-card-name flex-1 text-xl">{{ weapon.name }}</span>
                        <span
                            class="mh-value"
                            :class="getRarityColor(weapon.rarity)"
                        >{{ $t('Rarity') }} {{ weapon.rarity }}</span>
                    </div>

                    <div class="mh-rule" />

                    <div class="flex flex-wrap items-center gap-x-4 gap-y-2">
                        <span
                            v-for="attack in attacks"
                            :key="attack.slot"
                            class="flex items-center gap-1.5"
                        >
                            <img
                                :src="attack.slot > 3 ? comboAttack : damageAttack"
                                :alt="$t('Attacks')"
                                class="h-5 w-5"
                            >
                            <span class="mh-value">{{ attack.count }}</span>
                        </span>
                        <span
                            v-if="weapon.defense"
                            class="flex items-center gap-1.5"
                        >
                            <img
                                :src="defenseIcon"
                                :alt="$t('Defense')"
                                class="h-5 w-5"
                            >
                            <span class="mh-value">{{ weapon.defense }}</span>
                        </span>
                    </div>

                    <!-- Most weapons are made one way. Two dual blades can be
                         built from either of two monsters, at different prices. -->
                    <template
                        v-for="recipe in weapon.recipes"
                        :key="recipe.id"
                    >
                        <h3 class="mh-heading mt-2 text-xs tracking-widest uppercase">
                            {{ recipe.branch ?? $t('Materials') }}
                            <span
                                v-if="recipe.expansion"
                                class="text-parchment-dim"
                            >· {{ recipe.expansion_label }}</span>
                        </h3>
                        <ul class="flex flex-col gap-1 text-sm">
                            <li
                                v-for="item in recipe.items"
                                :key="item.id"
                                class="flex items-center justify-between gap-3"
                            >
                                <span class="text-gray-900 dark:text-parchment">{{ item.name }}</span>
                                <span class="mh-value">{{ item.pivot.number }}</span>
                            </li>
                        </ul>
                    </template>

                    <!-- What this weapon does to the attack deck, not just what it
                         costs: the cards it takes out and the ones it brings in. -->
                    <template v-if="weapon.attacks_to_remove?.length || weapon.attacks_to_add?.length">
                        <h3 class="mh-heading mt-2 text-xs tracking-widest uppercase">
                            {{ $t('Attack cards') }}
                        </h3>
                        <div class="flex flex-col gap-2 text-sm">
                            <div v-if="weapon.attacks_to_remove?.length">
                                <p class="text-xs text-gray-600 dark:text-gray-400">
                                    {{ $t('Removes') }}
                                </p>
                                <ul class="flex flex-col gap-1">
                                    <li
                                        v-for="attack in weapon.attacks_to_remove"
                                        :key="attack.id"
                                        class="flex items-center justify-between gap-3"
                                    >
                                        <span class="text-gray-900 dark:text-parchment">{{ attack.name }}</span>
                                        <span class="mh-value">{{ attack.pivot.number }}</span>
                                    </li>
                                </ul>
                            </div>
                            <div v-if="weapon.attacks_to_add?.length">
                                <p class="text-xs text-gray-600 dark:text-gray-400">
                                    {{ $t('Adds') }}
                                </p>
                                <ul class="flex flex-col gap-1">
                                    <li
                                        v-for="attack in weapon.attacks_to_add"
                                        :key="attack.id"
                                        class="flex items-center justify-between gap-3"
                                    >
                                        <span class="text-gray-900 dark:text-parchment">{{ attack.name }}</span>
                                        <span class="mh-value">{{ attack.pivot.number }}</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </template>

                    <div class="mh-rule mt-2" />

                    <dl class="flex flex-wrap gap-x-6 gap-y-1 text-sm text-gray-600 dark:text-gray-400">
                        <div
                            v-if="weapon.parent"
                            class="flex gap-2"
                        >
                            <dt>{{ $t('Upgrades from') }}</dt>
                            <dd>
                                <Link
                                    :href="route('wiki.weapon.show', [weapon.parent.id])"
                                    class="text-gray-900 underline dark:text-parchment"
                                >
                                    {{ weapon.parent.name }}
                                </Link>
                            </dd>
                        </div>
                        <div
                            v-if="weapon.children?.length"
                            class="flex flex-wrap gap-2"
                        >
                            <dt>{{ $t('Upgrades to') }}</dt>
                            <dd
                                v-for="child in weapon.children"
                                :key="child.id"
                            >
                                <Link
                                    :href="route('wiki.weapon.show', [child.id])"
                                    class="text-gray-900 underline dark:text-parchment"
                                >
                                    {{ child.name }}
                                </Link>
                            </dd>
                        </div>
                    </dl>
                </Card>

                <CraftWithHunter
                    :hunters="hunters"
                    :weapon="weapon"
                />
            </div>
        </div>
    </AppLayout>
</template>
