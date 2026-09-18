<script setup>
import _ from "lodash";
import {router} from "@inertiajs/vue3";
import Card from "@/Components/Card.vue";
import Check from "@/Components/Icons/Check.vue";

const props = defineProps({
    canEdit: Boolean,
    campaign: Object,
    hunter: Object,
    weaponTypes: [Array, Object],
});

const countWeaponCrafted = (weaponType) => {
    return _.countBy(props.hunter.weapons, (weapon) => weapon.type_id === weaponType.id).true ?? 0;
};

// The favourite of a type, or its starting weapon when nothing has been picked.
const weaponEquipped = (weaponType) => {
    const equipped = _.find(props.hunter.equipped_weapons, (weapon) => weapon.type_id === weaponType.id);
    if (equipped) return equipped;

    return _.find(weaponType.weapons, (weapon) => weapon.is_default);
};

const carried = (weaponType) => props.hunter.weapon_type_id === weaponType.id;

const openWeaponType = (weaponType) => {
    router.visit(route('campaigns.hunters.weapon-type.index', [props.campaign, props.hunter, weaponType]), {
        preserveScroll: true,
    });
};

</script>

<template>
    <div class="mt-6 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
        <Card
            v-for="weaponType in weaponTypes"
            :key="weaponType.id"
            class="gap-2"
            :owned="!!countWeaponCrafted(weaponType)"
            :equipped="carried(weaponType)"
        >
            <button
                type="button"
                class="flex cursor-pointer items-center gap-3 text-left"
                @click="openWeaponType(weaponType)"
            >
                <span class="relative flex h-10 w-10 min-h-10 min-w-10 items-center justify-center rounded-full bg-gray-300 dark:bg-gray-900">
                    <img
                        class="h-6 w-6"
                        :src="weaponType.image_url"
                        :alt="weaponType.name"
                    >
                    <span
                        v-if="countWeaponCrafted(weaponType) > 1"
                        class="absolute -right-1 -bottom-1 flex h-4 min-w-4 items-center justify-center rounded-full bg-gray-300 px-0.5 text-[0.6rem] leading-none font-bold text-primary-500 tabular-nums dark:bg-gray-900"
                    >{{ countWeaponCrafted(weaponType) }}</span>
                    <Check
                        v-else-if="countWeaponCrafted(weaponType)"
                        class="absolute -right-1 -bottom-1 h-4 w-4 rounded-full bg-gray-300 text-primary-500 dark:bg-gray-900"
                    />
                </span>
                <span class="mh-card-name flex-1 text-base">{{ weaponType.name }}</span>
            </button>

            <div class="mh-rule" />

            <div class="flex flex-wrap items-baseline gap-x-2 text-sm text-gray-600 dark:text-gray-400">
                <span class="mh-value">{{ countWeaponCrafted(weaponType) }}</span>
                <span>{{ $t('crafted.') }}</span>
            </div>

            <div
                v-if="weaponEquipped(weaponType)"
                class="text-sm"
            >
                <span class="text-gray-600 dark:text-gray-400">{{ $t('Equipped') }}:</span>
                <span class="ml-1 text-gray-900 dark:text-parchment">{{ weaponEquipped(weaponType).name }}</span>
            </div>
        </Card>
    </div>
</template>
