<script setup>
import 'md-editor-v3/lib/style.css';

import {MdEditor, config} from 'md-editor-v3';
import {computed, onBeforeUnmount, onMounted, ref} from 'vue';

// The stored markdown is rendered server side with CommonMark's `html_input: strip`.
// Turning raw HTML off here keeps the preview honest about what readers will see.
//
// The same reasoning switches off five of the editor's own extras in the template
// below: KaTeX formulas, Mermaid diagrams, syntax highlighting, ECharts and the
// Prettier formatter. CommonMark renders none of them, so the preview was showing a
// formula or a coloured code block that no reader would ever get. They were also the
// editor's only third-party requests: each one is fetched at runtime from
// `unpkg.com` (`md-editor-v3/lib/es/chunks/config.mjs`), which handed every visitor's
// address to that CDN on the two campaign forms, in an app that otherwise talks to
// nobody from the browser but reCAPTCHA. Cropper is already off through
// `no-upload-img`, and screenfull is only fetched by the `fullscreen` toolbar button,
// which is not in the toolbar (`pageFullscreen` is, and needs nothing).
// `wysiwygInput.test.ts` mounts the real editor and fails on any remote `<link>` or
// `<script>` it adds.
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
//
// Read lazily and guarded, because this runs during `setup`, which the SSR server runs
// too and where there is no `document`: unguarded, it threw and sent both campaign forms
// back to client rendering. The server renders the light editor; the browser renders the
// page again on load (`app.ts` mounts with `createApp`, it does not hydrate), so a dark
// visitor sees the right theme from the first client render.
const isDark = () => typeof document !== 'undefined' && document.documentElement.classList.contains('dark');

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
    <div
        class="mh-notch overflow-hidden border border-gray-300 dark:border-gray-700 [--mh-notch-color:var(--color-gray-400)] focus-within:border-primary-500 focus-within:[--mh-notch-color:var(--color-primary-800)] dark:[--mh-notch-color:var(--color-gray-600)] dark:focus-within:border-primary-600 dark:focus-within:[--mh-notch-color:var(--color-primary-200)]"
    >
        <MdEditor
            ref="editor"
            v-model="value"
            :theme="theme"
            :toolbars="toolbars"
            :footers="[]"
            :no-upload-img="true"
            :no-katex="true"
            :no-mermaid="true"
            :no-highlight="true"
            :no-echarts="true"
            :no-prettier="true"
            :preview="false"
            language="en-US"
            style="height: 500px"
        />
    </div>
</template>
