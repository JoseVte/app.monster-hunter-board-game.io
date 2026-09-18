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
        <div class="px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
            <div class="sm:flex sm:items-start">
                <div class="mx-auto shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                    <svg
                        class="h-6 w-6 text-red-600 dark:text-red-400"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"
                        />
                    </svg>
                </div>

                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                        <slot name="title" />
                    </h3>

                    <div class="mt-4 text-sm text-gray-600 dark:text-gray-400">
                        <slot name="content" />
                    </div>
                </div>
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
