<script setup lang="ts">
import {h, ref} from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import Breadcrumb from "@/Components/Breadcrumb.vue";
import WeaponsIcon from "@/Components/Icons/WeaponsIcon.vue";
import LoadingOverlay from "@/Components/LoadingOverlay.vue";
import ListWeapons from "@/Pages/Hunter/Partials/ListWeapons.vue";
import WikiFilters from "@/Pages/Wiki/Partials/WikiFilters.vue";

// `WeaponController::filters()`/`options()`'s own shape; no model backs it.
type WikiFilterValues = {
    q: string | null;
    rarity: number | null;
    expansion: string | null;
    branch: string | null;
};

type WikiFilterOptions = {
    rarities: number[];
    expansions: Array<{key: string; label: string}>;
    branches: Array<{key: string; label: string}>;
};

// `create_weapon_tree()` (`app/Support/helpers.php`) bolts these five fields
// onto every `Weapon` in the type before handing the collection to this page;
// no model or generated type describes them. `ListWeapons.vue`, the actual
// reader of `weapons` below, is not converted by this task (it is also used
// by `Hunter/Show.vue`, outside `Pages/Wiki/**`) and still declares its own
// props as plain `Object`/`Array`, so this page's own type is not checked
// against it. It is declared here anyway because it is the true shape of
// what the controller sends, for whoever types `ListWeapons.vue` next.
type WeaponTreeWeapon = App.Models.Weapon & {
    // `$hunter?->equippedWeapons->firstWhere(...)`; always `null` here, since
    // `WeaponController::show()` never passes a `$hunter`.
    equipped: App.Models.Weapon | null;
    craftable_recipes: number[];
    can_craft: boolean;
    path_ids: number[];
    missing_chain: WeaponTreeWeapon[];
    chain_items: Array<{id: number; name: string; number: number}>;
};

type WeaponTreeEntry = {
    root: WeaponTreeWeapon;
    paths: Array<{branches: string[]; weapons: WeaponTreeWeapon[]}>;
};

const props = defineProps<{
    weaponType: App.Models.WeaponType;
    weapons: WeaponTreeEntry[];
    matching: number[];
    filters: WikiFilterValues;
    options: WikiFilterOptions;
}>();

// The tree itself never changes with a filter, only which weapons in it match,
// so a filter only ever needs to ask the server for `matching` again.
const loading = ref(false);

// Breadcrumb's icon slot wants a component, not a URL, so the type's own image
// is wrapped in one rather than falling back to the generic weapons glyph.
const typeIcon = () => h('img', {src: props.weaponType.image_url, alt: props.weaponType.name});
</script>

<template>
    <AppLayout :title="weaponType.name">
        <template #header>
            <Breadcrumb
                :current-title="weaponType.name"
                :breadcrumbs="[
                    { url: route('wiki.index'), title: $t('Wiki') },
                    { url: route('wiki.weapon.index'), title: $t('Weapons'), icon: WeaponsIcon },
                ]"
                :icon="typeIcon"
            />
        </template>

        <div class="py-6 sm:py-12">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <WikiFilters
                    :filters="filters"
                    :options="options"
                    route-name="wiki.weapon.type"
                    :route-params="[weaponType.id]"
                    :only="['matching', 'filters']"
                    @loading="loading = $event"
                />

                <!-- The whole tree, with what does not match the filters dimmed
                     rather than removed: a line with a gap in it reads as a
                     broken line, not as a filtered one. -->
                <LoadingOverlay :loading="loading">
                    <ListWeapons
                        :weapon-type="weaponType"
                        :weapons="weapons"
                        :matching="matching"
                    />
                </LoadingOverlay>
            </div>
        </div>
    </AppLayout>
</template>
