<script setup>
import {computed} from "vue";
import noteWhite from '~/icons/song-note-white-icon.png';
import noteRed from '~/icons/song-note-red-icon.png';
import noteBlue from '~/icons/song-note-blue-icon.png';

// The run of notes a song is played with, in the order the card prints them.
// Two songs differ by that run alone, so the order carries the meaning.
const props = defineProps({
    notes: {
        type: Array,
        required: true,
    },
});

const artwork = {
    white: {src: noteWhite, alt: 'White note'},
    red: {src: noteRed, alt: 'Red note'},
    blue: {src: noteBlue, alt: 'Blue note'},
};

const drawn = computed(() => props.notes.map((note) => artwork[note]).filter(Boolean));
</script>

<template>
    <span class="flex shrink-0 items-center gap-1">
        <img
            v-for="(note, index) in drawn"
            :key="index"
            :src="note.src"
            :alt="note.alt"
            :title="note.alt"
            class="h-6 w-6"
        >
    </span>
</template>
