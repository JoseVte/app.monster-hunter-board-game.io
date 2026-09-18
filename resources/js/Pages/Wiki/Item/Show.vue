<script setup>
import {h} from "vue";
import {Link} from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import Breadcrumb from "@/Components/Breadcrumb.vue";
import ItemsIcon from "@/Components/Icons/ItemsIcon.vue";
import ArmorsIcon from "@/Components/Icons/ArmorsIcon.vue";
import HelmetIcon from "@/Components/Icons/HelmetIcon.vue";
import LegArmor from "@/Components/Icons/LegArmor.vue";
import Card from "@/Components/Card.vue";
import WeaponTypeIcon from "@/Components/WeaponTypeIcon.vue";
import {getRarityColor} from "@/rarity";

const props = defineProps({
    item: Object,
});

// Breadcrumb's icon slot wants a component, not a URL, so the item's own icon
// is wrapped in one rather than falling back to the generic items glyph.
const currentIcon = () => h('img', {src: props.item.icon_url, alt: props.item.name});

// The same three slots the armour card itself keys its icon by.
const ARMOR_ICONS = {head: HelmetIcon, body: ArmorsIcon, leg: LegArmor};
</script>

<template>
    <AppLayout :title="item.name">
        <template #header>
            <Breadcrumb
                :current-title="item.name"
                :breadcrumbs="[
                    { url: route('wiki.index'), title: $t('Wiki') },
                    { url: route('wiki.item.index'), title: $t('Items'), icon: ItemsIcon },
                ]"
                :icon="currentIcon"
            />
        </template>

        <div class="py-6 sm:py-12">
            <div class="mx-auto max-w-2xl px-4 sm:px-6 lg:px-8">
                <Card class="gap-3 p-5">
                    <div class="flex items-center gap-3">
                        <span class="flex h-10 w-10 min-h-10 min-w-10 items-center justify-center overflow-hidden rounded-full bg-gray-300 dark:bg-gray-900">
                            <img
                                :src="item.icon_url"
                                :alt="item.name"
                                class="h-8 w-8 object-contain"
                            >
                        </span>
                        <span class="mh-card-name flex-1 text-xl">{{ item.name }}</span>
                        <span class="mh-value">{{ item.type }}</span>
                    </div>

                    <div class="mh-rule" />

                    <!-- Where it comes from, which is the whole question when a
                         hunter is short of one. -->
                    <template v-if="item.monsters?.length">
                        <h3 class="mh-heading text-xs tracking-widest uppercase">
                            {{ $t('Monster') }}
                        </h3>
                        <ul class="flex flex-col gap-1 text-sm">
                            <li
                                v-for="monster in item.monsters"
                                :key="monster.id"
                                class="flex items-center gap-2"
                            >
                                <img
                                    :src="monster.icon_url"
                                    :alt="monster.name"
                                    class="h-4 w-4 rounded-full object-contain"
                                >
                                <Link
                                    :href="route('wiki.monster.show', [monster.id])"
                                    class="text-gray-900 underline dark:text-parchment"
                                >
                                    {{ monster.name }}
                                </Link>
                            </li>
                        </ul>
                    </template>

                    <p
                        v-else
                        class="text-sm text-gray-600 dark:text-parchment-dim"
                    >
                        {{ $t('This one drops from no monster.') }}
                    </p>

                    <!-- The other half of the question: not just where it comes
                         from, but what it is for. -->
                    <template v-if="item.weapons?.length">
                        <h3 class="mh-heading mt-2 text-xs tracking-widest uppercase">
                            {{ $t('Weapons') }}
                        </h3>
                        <ul class="flex flex-col gap-1 text-sm">
                            <li
                                v-for="weapon in item.weapons"
                                :key="weapon.id"
                                class="flex items-center gap-2"
                            >
                                <WeaponTypeIcon
                                    :weapon-type="weapon.type"
                                    class="h-4 w-4"
                                    :class="getRarityColor(weapon.rarity)"
                                />
                                <Link
                                    :href="route('wiki.weapon.show', [weapon.id])"
                                    class="text-gray-900 underline dark:text-parchment"
                                >
                                    {{ weapon.name }}
                                </Link>
                            </li>
                        </ul>
                    </template>

                    <template v-if="item.armors?.length">
                        <h3 class="mh-heading mt-2 text-xs tracking-widest uppercase">
                            {{ $t('Armors') }}
                        </h3>
                        <ul class="flex flex-col gap-1 text-sm">
                            <li
                                v-for="armor in item.armors"
                                :key="armor.id"
                                class="flex items-center gap-2"
                            >
                                <component
                                    :is="ARMOR_ICONS[armor.type_value]"
                                    class="h-4 w-4"
                                    :class="getRarityColor(armor.rarity)"
                                />
                                <Link
                                    :href="route('wiki.armor.show', [armor.id])"
                                    class="text-gray-900 underline dark:text-parchment"
                                >
                                    {{ armor.name }}
                                </Link>
                            </li>
                        </ul>
                    </template>
                </Card>
            </div>
        </div>
    </AppLayout>
</template>
