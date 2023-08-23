<script setup>
import '@toast-ui/editor/dist/toastui-editor-viewer.css';
import '@toast-ui/editor/dist/theme/toastui-editor-dark.css';
import Viewer from '@toast-ui/editor/dist/toastui-editor-viewer';
import {onMounted, ref} from 'vue';

const props = defineProps({
    text: String,
});

let theme = localStorage.getItem('color-theme')

const container = ref(null);
const input = ref(null);


onMounted(() => {
    new Viewer({
        el: input.value,
        initialValue: props.text,
        theme: theme,
    });
});

defineExpose({ focus: () => input.value.focus() });
</script>

/>
<template>
    <div ref="container">
        <div ref="input" />
    </div>
</template>
