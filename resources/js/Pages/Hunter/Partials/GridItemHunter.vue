<script setup>
import _ from "lodash";
import UpdateCountItemForm from "@/Pages/Hunter/Partials/UpdateCountItemForm.vue";

const props = defineProps({
    canEdit: Boolean,
    hideEmpty: Boolean,
    campaign: Object,
    hunter: Object,
    items: Array,
});

const chunkArray = (arr) => {
    const middleIndex = Math.ceil(arr.length / 2);

    return [
        arr.slice(0, middleIndex),
        arr.slice(middleIndex),
    ];
}

const countItem = (item) => {
    const hunterItemCount = _.find(props.hunter.items, (hunterItem) => {
        return item.id === hunterItem.pivot.item_id
    });
    if (hunterItemCount) {
        return hunterItemCount.pivot.number;
    }

    return 0;
}
</script>

<template>
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 sm:gap-4">
        <div
            v-for="(chunkItems, index) in chunkArray(items)"
            :key="index"
            class="grid grid-cols-1 gap-2 h-fit"
        >
            <UpdateCountItemForm
                v-for="item in chunkItems"
                :key="item.id"
                :can-edit="canEdit"
                :hide-empty="hideEmpty"
                :campaign="campaign"
                :hunter="hunter"
                :item="item"
                :count-item="countItem(item)"
            />
        </div>
    </div>
</template>

<style scoped>

</style>
