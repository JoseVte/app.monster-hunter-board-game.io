<script setup lang="ts">
import {computed} from "vue";
import noteWhite from '~/icons/song-note-white-icon.png';
import noteRed from '~/icons/song-note-red-icon.png';
import noteBlue from '~/icons/song-note-blue-icon.png';

// The run of notes a song is played with, in the order the card prints them.
// Two songs differ by that run alone, so the order carries the meaning.
type Note = 'white' | 'red' | 'blue';

// The generated `Song.notes` column is `unknown[]`, a plain JSON cast with no
// narrower shape, so the prop keeps that real, ungoverned type rather than
// asserting the three colours below straight onto it, and a value is checked
// against the map's own keys before it is used to index into it, the same
// shape `WeaponStats.vue`'s `isDeviationKey` guard uses for a comparably
// ungoverned field.
const props = defineProps<{
    notes: unknown[];
}>();

const artwork: Record<Note, {src: string; alt: string}> = {
    white: {src: noteWhite, alt: 'White note'},
    red: {src: noteRed, alt: 'Red note'},
    blue: {src: noteBlue, alt: 'Blue note'},
};

// `in` walks the prototype chain, so `'toString' in artwork` is `true` and
// `isNote('toString')` would wrongly say yes; `Object.hasOwn` checks the
// object's own keys only.
const isNote = (value: unknown): value is Note => typeof value === 'string' && Object.hasOwn(artwork, value);

const drawn = computed(() => props.notes
    .map((note) => (isNote(note) ? artwork[note] : null))
    .filter((entry) => entry !== null));
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
