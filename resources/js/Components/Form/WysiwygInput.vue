<script setup>
import 'md-editor-v3/lib/style.css';

import {MdEditor, config} from 'md-editor-v3';
import {computed, onBeforeUnmount, onMounted, ref} from 'vue';

// The stored markdown is rendered server side with CommonMark's `html_input: strip`.
// Turning raw HTML off here keeps the preview honest about what readers will see.
config({
    markdownItConfig: (md) => md.set({html: false}),
});

const props = defineProps({
    modelValue: String,
});

const emit = defineEmits(['update:modelValue']);

const editor = ref(null);

const value = computed({
    get: () => props.modelValue ?? '',
    set: (markdown) => emit('update:modelValue', markdown),
});

// The `dark` class on <html> is the source of truth, not localStorage: the key is unset
// until the user toggles the theme at least once, so a fresh visitor following the OS
// preference would otherwise always get the light editor.
const isDark = () => document.documentElement.classList.contains('dark');

const theme = ref(isDark() ? 'dark' : 'light');
const syncTheme = () => theme.value = isDark() ? 'dark' : 'light';

onMounted(() => document.addEventListener('toggleDarkMode', syncTheme));
onBeforeUnmount(() => document.removeEventListener('toggleDarkMode', syncTheme));

const toolbars = [
    'title', 'bold', 'italic', 'strikeThrough',
    '-',
    'quote', 'unorderedList', 'orderedList', 'task',
    '-',
    'table', 'link', 'codeRow', 'code',
    '-',
    'revoke', 'next',
    '=',
    'preview', 'pageFullscreen',
];

defineExpose({focus: () => editor.value?.focus()});
</script>

<template>
    <div class="rounded-md shadow-sm overflow-hidden border border-gray-300 dark:border-gray-700">
        <MdEditor
            ref="editor"
            v-model="value"
            :theme="theme"
            :toolbars="toolbars"
            :footers="[]"
            :no-upload-img="true"
            :preview="false"
            language="en-US"
            style="height: 500px"
        />
    </div>
</template>
