<script setup>
import {h, ref} from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import Breadcrumb from "@/Components/Breadcrumb.vue";
import WeaponsIcon from "@/Components/Icons/WeaponsIcon.vue";
import LoadingOverlay from "@/Components/LoadingOverlay.vue";
import ListWeapons from "@/Pages/Hunter/Partials/ListWeapons.vue";
import WikiFilters from "@/Pages/Wiki/Partials/WikiFilters.vue";

const props = defineProps({
    weaponType: Object,
    weapons: [Array, Object],
    matching: Array,
    filters: Object,
    options: Object,
});

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
