<script setup>
import '@toast-ui/editor/dist/toastui-editor.css';
import '@toast-ui/editor/dist/theme/toastui-editor-dark.css';
import '@toast-ui/editor-plugin-table-merged-cell/dist/toastui-editor-plugin-table-merged-cell.css';
import 'tui-color-picker/dist/tui-color-picker.css';
import '@toast-ui/editor-plugin-color-syntax/dist/toastui-editor-plugin-color-syntax.css';
import 'prismjs/themes/prism.css';
import '@toast-ui/editor-plugin-code-syntax-highlight/dist/toastui-editor-plugin-code-syntax-highlight.css';

import {Editor} from '@toast-ui/editor';
import tableMergedCell from '@toast-ui/editor-plugin-table-merged-cell';
import colorSyntax from '@toast-ui/editor-plugin-color-syntax';
import codeSyntaxHighlight from '@toast-ui/editor-plugin-code-syntax-highlight';
import {onMounted, ref} from 'vue';

const props = defineProps({
    modelValue: String,
    wysiwygOptions: {
        type: String,
        default: 'public'
    }
});

let theme = localStorage.getItem('color-theme')

const emit = defineEmits(['update:modelValue']);
const container = ref(null);
const input = ref(null);

const publicWysiwygOptions = [
    ['heading', 'bold', 'italic', 'strike'],
    ['hr', 'quote'],
    ['ul', 'ol', 'task', 'indent', 'outdent'],
    ['table', 'link'],
    ['code'],
]
const completeWysiwygOptions = [
    ['heading', 'bold', 'italic', 'strike'],
    ['hr', 'quote'],
    ['ul', 'ol', 'task', 'indent', 'outdent'],
    ['table', 'image', 'link'],
    ['code', 'codeblock'],
]

const publicWysiwygPlugins = [
    tableMergedCell,
    colorSyntax,
]
const completeWysiwygPlugins = [
    tableMergedCell,
    colorSyntax,
    codeSyntaxHighlight,
]

onMounted(() => {
    const e = new Editor({
        autofocus: container.value.hasAttribute('autofocus'),
        el: input.value,
        height: '500px',
        theme: theme,
        initialValue: props.modelValue,
        initialEditType: 'wysiwyg',
        events: {
            change: () => emit('update:modelValue', e.getMarkdown()),
        },
        toolbarItems: props.wysiwygOptions === 'public' ? publicWysiwygOptions : completeWysiwygOptions,
        plugins: props.wysiwygOptions === 'public' ? publicWysiwygPlugins : completeWysiwygPlugins
    });
});

defineExpose({ focus: () => input.value.focus() });
</script>

/>
<template>
    <div
        ref="container"
        class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-primary-500 dark:focus:border-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 rounded-md shadow-sm"
    >
        <div
            ref="input"
        />
    </div>
</template>
