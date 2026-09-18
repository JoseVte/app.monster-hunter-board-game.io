<script setup>
import Modal from './Modal.vue';

const emit = defineEmits(['close']);

defineProps({
    show: {
        type: Boolean,
        default: false,
    },
    maxWidth: {
        type: String,
        default: '2xl',
    },
    closeable: {
        type: Boolean,
        default: true,
    },
});

const close = () => {
    emit('close');
};
</script>

<template>
    <Modal
        :show="show"
        :max-width="maxWidth"
        :closeable="closeable"
        @close="close"
    >
        <div class="px-6 py-4">
            <div class="text-lg font-medium text-gray-900 dark:text-gray-100">
                <slot name="title" />
            </div>

            <div class="mt-4 text-sm text-gray-600 dark:text-gray-400">
                <slot name="content" />
            </div>
        </div>

        <!-- The rule the cards use, rather than a grey bar under the panel: inside a
         frame there is nothing to sit under. The footer stacks so the rule spans
         the whole width instead of taking its place in the row of buttons. -->
        <div class="flex flex-col px-6 pt-4 pb-6 before:mb-4 before:block before:h-px before:w-full before:bg-[linear-gradient(to_right,transparent,var(--color-attack-line),transparent)] before:content-['']">
            <div class="flex flex-row justify-end gap-3">
                <slot name="footer" />
            </div>
        </div>
    </Modal>
</template>
