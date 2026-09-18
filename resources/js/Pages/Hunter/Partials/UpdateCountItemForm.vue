<script setup>
import {Link, useForm} from "@inertiajs/vue3";
import CountForm from "@/Components/Form/CountForm.vue";

const props = defineProps({
    canEdit: Boolean,
    hideEmpty: Boolean,
    campaign: Object,
    hunter: Object,
    item: Object,
    countItem: Number,
});

const form = useForm({
    count_item: props.countItem,
});

const incrementItem = () => {
    form.count_item++;
    form.put(route('campaigns.hunters.items.update-count', [props.campaign, props.hunter, props.item]), {
        errorBag: 'updateHunterItem',
        preserveScroll: true,
    });
}
const decrementItem = () => {
    form.count_item--;
    form.put(route('campaigns.hunters.items.update-count', [props.campaign, props.hunter, props.item]), {
        errorBag: 'updateHunterItem',
        preserveScroll: true,
    });
}
</script>

<template>
    <div
        v-if="!(hideEmpty && countItem === 0)"
        class="flex items-center justify-between"
    >
        <div class="text-gray-800 dark:text-white font-semibold">
            <Link
                :href="route('wiki.item.show', item)"
                class="hover:underline"
            >
                {{ item.name }}
            </Link>
        </div>
        <div class="text-gray-700 dark:text-gray-100">
            <CountForm
                v-if="canEdit"
                :form="form"
                :decrement="decrementItem"
                :increment="incrementItem"
                :value="countItem"
                class="w-full mt-1"
            />
            <div
                v-else
                class="mh-notch flex h-10 w-20 items-center justify-center border border-gray-400 bg-white/70 px-4 text-center text-md font-semibold text-gray-800 [--mh-notch-color:var(--color-gray-500)] dark:border-gray-600 dark:bg-gray-950/60 dark:text-parchment"
            >
                {{ countItem }}
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
