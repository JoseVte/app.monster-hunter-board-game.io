<script setup>
import { computed, useSlots } from 'vue';
import SectionTitle from '@/Components/SectionTitle.vue';

defineEmits(['submitted']);

const hasActions = computed(() => !! useSlots().actions);
</script>

<template>
    <div class="md:grid md:grid-cols-3 md:gap-6">
        <SectionTitle>
            <template #title>
                <slot name="title" />
            </template>
            <template #description>
                <slot name="description" />
            </template>
        </SectionTitle>

        <div class="mt-5 md:mt-0 md:col-span-2">
            <form @submit.prevent="$emit('submitted')">
                <!-- The frame the hunter sheet is drawn with. The fields and the
                     actions share one, since a frame with its corners marked
                     cannot be cut in half and still read as a single panel. -->
                <div class="mh-frame bg-white px-4 py-5 sm:p-6 dark:bg-gray-800">
                    <div class="grid grid-cols-6 gap-6">
                        <slot name="form" />
                    </div>

                    <div
                        v-if="hasActions"
                        class="mt-6 flex items-center justify-end gap-3 pt-4 before:hidden"
                    >
                        <slot name="actions" />
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>
