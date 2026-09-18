<script setup>
// A generic marker: five diamonds in a cross/plus arrangement, the ones
// matching the part's own direction(s) highlighted. Not tied to any specific
// illustration, just a simple original geometric shape for pointing at
// "this side" instead of the plain arrow character.
const props = defineProps({
    // e.g. 'up', 'left-right', 'up-left-right', matching MonsterPart.direction.
    direction: {
        type: String,
        default: '',
    },
});

const POSITIONS = {
    up: {x: 12, y: 4},
    down: {x: 12, y: 20},
    left: {x: 4, y: 12},
    right: {x: 20, y: 12},
};

const isActive = (name) => props.direction.split('-').includes(name);

const diamond = (x, y, size = 4) => `${x},${y - size} ${x + size},${y} ${x},${y + size} ${x - size},${y}`;

// The centre marks the part itself rather than a side. Built as the same
// plus shape as before, then rotated 45deg in the template so its arms run
// between the diamonds instead of into them. The arm reaches past the
// diamonds' own outer edge (they sit 8 from centre, 4 wide) rather than
// stopping short of them.
const cross = (x, y, armLength = 10, thickness = 0.5) => `
    ${x - thickness},${y - armLength} ${x + thickness},${y - armLength}
    ${x + thickness},${y - thickness} ${x + armLength},${y - thickness}
    ${x + armLength},${y + thickness} ${x + thickness},${y + thickness}
    ${x + thickness},${y + armLength} ${x - thickness},${y + armLength}
    ${x - thickness},${y + thickness} ${x - armLength},${y + thickness}
    ${x - armLength},${y - thickness} ${x - thickness},${y - thickness}
`;
</script>

<template>
    <svg
        viewBox="0 0 24 24"
        xmlns="http://www.w3.org/2000/svg"
    >
        <polygon
            :points="cross(12, 12)"
            transform="rotate(45 12 12)"
            fill="currentColor"
        />
        <template
            v-for="(position, name) in POSITIONS"
            :key="name"
        >
            <polygon
                :points="diamond(position.x, position.y)"
                :fill="isActive(name) ? '#3b82f6' : 'currentColor'"
            />
            <circle
                v-if="isActive(name)"
                :cx="position.x"
                :cy="position.y"
                r="1.3"
                fill="#fff"
            />
        </template>
    </svg>
</template>
