<script setup>
import { computed, onMounted, ref } from "vue";
import { Link, useForm } from "@inertiajs/vue3";
import _ from "lodash";
import CogIcon from "@/Components/Icons/CogIcon.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import WeaponsIcon from "@/Components/Icons/WeaponsIcon.vue";
import Check from "@/Components/Icons/Check.vue";
import CraftWeaponModal from "@/Pages/Hunter/Partials/CraftWeaponModal.vue";

const props = defineProps({
    canEdit: Boolean,
    campaign: Object,
    hunter: Object,
    weaponType: Object,
    weapons: [Array, Object],
});

const hunterWeaponCount = (weapon) => _.filter(
    props.hunter.weapons,
    (hunterWeapon) => hunterWeapon.id === weapon.id,
).length;

// Hovering a weapon lights the line that made it. The server hands each weapon
// the ids back to its root, so this is a lookup rather than a walk up parents.
const scroller = ref(null);

// A tree runs several screens wide, so opening it at the first rarity hides the
// weapon actually in hand. Only the horizontal offset is moved: scrollIntoView
// would drag the page itself past the header as well.
onMounted(() => {
    const centreOnEquipped = () => {
        const box = scroller.value?.getBoundingClientRect();

        // The tree sits inside a tab that Hunter/Show selects after this mounts,
        // so at this point the panel is still display:none and every rectangle
        // is zero. Waiting for a width is what makes the scroll land.
        if (! box?.width) return false;

        const equipped = scroller.value.querySelector('.mh-card-equipped');
        if (! equipped) return true;

        const card = equipped.getBoundingClientRect();
        scroller.value.scrollLeft += card.left - box.left - (box.width - card.width) / 2;

        return true;
    };

    if (centreOnEquipped()) return;

    const observer = new ResizeObserver(() => {
        if (centreOnEquipped()) observer.disconnect();
    });

    observer.observe(scroller.value);
});

const litPath = ref([]);
const light = (weapon) => { litPath.value = weapon.path_ids ?? []; };
const unlight = () => { litPath.value = []; };
const isLit = (weapon) => litPath.value.includes(weapon.id);

// Rarity is the x axis, the way the game lays a weapon tree out. A path that
// starts at rarity four rather than two leaves its early columns empty, and
// that gap is the point: it says how much further along the line begins.
// One path continues the root's own material line, mineral or bone, so it
// belongs on the root's row rather than under it.
const rootBranches = (root) => (root.recipes ?? []).map((recipe) => recipe.branch).filter(Boolean);

const sharedPath = (entry) => entry.paths.find(
    (path) => path.branches.some((branch) => rootBranches(entry.root).includes(branch)),
) ?? entry.paths[0];

const otherPaths = (entry) => entry.paths.filter((path) => path !== sharedPath(entry));

// A connector spans from the tier the previous box sits in to this one, so it
// stays joined however many empty tiers lie between them.
const cameFrom = (path, index, root) => (index === 0 ? root.rarity : path.weapons[index - 1].rarity);

// Tiers shift one column right to leave room for the rotated branch names, so a
// weapon of rarity R lives between grid lines R+1 and R+2.
const linkStyle = (path, step, root, weapon, row) => {
    if (step === 0 && row > 0) {
        return { gridColumn: `2 / ${weapon.rarity + 1}`, gridRow: `1 / ${row + 2}` };
    }

    const from = cameFrom(path, step, root);

    // Neighbouring tiers have no track between them, only the gap, so the line
    // shares the target's column and reaches back into it.
    return from + 1 === weapon.rarity
        ? { gridColumn: weapon.rarity + 1, gridRow: row + 1 }
        : { gridColumn: `${from + 2} / ${weapon.rarity + 1}`, gridRow: row + 1 };
};

const linkClass = (path, step, root, weapon, row) => {
    if (step === 0 && row > 0) {
        return 'mh-elbow';
    }

    return cameFrom(path, step, root) + 1 === weapon.rarity ? 'mh-link mh-link-tight' : 'mh-link';
};

// One type goes to the fight and a hunter never goes out empty handed, so the
// one in hand cannot be put down, only replaced by picking another.
const carried = computed(() => props.hunter.weapon_type_id === props.weaponType.id);

const form = useForm({});
const carry = () => {
    form.put(route('campaigns.hunters.weapon-type.hunt', [props.campaign, props.hunter, props.weaponType]), {
        preserveScroll: true,
    });
};

const maxRarity = computed(() => Math.max(
    5,
    ...Object.values(props.weapons).flatMap(
        (entry) => entry.paths.flatMap((path) => path.weapons.map((w) => w.rarity)),
    ),
));
</script>

<template>
    <div class="mt-6 px-4 sm:px-0">
        <Link
            :href="route('campaigns.hunters.show', [campaign, hunter, 'weapons'])"
            class="flex items-center text-sm text-gray-800 dark:text-gray-200"
            preserve-scroll
        >
            <svg
                class="mr-2 h-5 w-5"
                fill="none"
                stroke="currentColor"
                stroke-width="1.5"
                viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg"
                aria-hidden="true"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M18.75 19.5l-7.5-7.5 7.5-7.5m-6 15L5.25 12l7.5-7.5"
                />
            </svg>
            {{ $t('Back to all weapon types') }}
        </Link>

        <!-- The choice of what to hunt with lives with the tree, where a player
             can see the weapon before taking it. -->
        <div
            v-if="canEdit"
            class="mt-4 flex items-center gap-3"
        >
            <SecondaryButton
                v-if="carried"
                class="justify-center gap-2"
                disabled
            >
                <CogIcon class="h-4 w-4" />
                {{ $t('Carrying') }}
            </SecondaryButton>
            <SecondaryButton
                v-else
                class="group justify-center gap-2"
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing"
                @click="carry"
            >
                <CogIcon class="h-4 w-4 transition-all group-hover:rotate-180 group-hover:text-primary-400" />
                {{ $t('Hunt with this') }}
            </SecondaryButton>

            <span class="text-sm text-gray-600 dark:text-gray-400">
                {{ carried ? $t('This is the weapon you take to a hunt.') : $t('Only one weapon type comes to a hunt.') }}
            </span>
        </div>

        <div
            ref="scroller"
            class="mt-6 overflow-x-auto pb-2"
        >
            <div
                v-for="entry in weapons"
                :key="entry.root.id"
                class="mh-tree mt-8 grid min-w-max items-stretch gap-x-6 gap-y-4"
                :style="{ gridTemplateColumns: `2.25rem repeat(${maxRarity}, var(--mh-col))` }"
            >
                <!-- The root and the path that continues its own material share a
                     row; the other monsters branch off underneath. -->
                <div
                    class="relative z-10 col-start-2 row-start-1"
                    @mouseenter="light(entry.root)"
                    @mouseleave="unlight"
                >
                    <div>
                        <CraftWeaponModal
                            :campaign="campaign"
                            :hunter="hunter"
                            :weapon="entry.root"
                            :class-container="isLit(entry.root) ? 'mh-card-lit' : ''"
                        >
                            <div class="flex items-center gap-3">
                                <!-- The owned mark rides on the icon. On its own line it took
                                 32px of a 165px card, which left thirteen of the twenty
                                 names in this tree too little room and clipped the longest
                                 of them mid word. -->
                                <span class="relative flex h-8 w-8 min-h-8 min-w-8 items-center justify-center rounded-full bg-gray-300 dark:bg-gray-900">
                                    <WeaponsIcon
                                        class="h-4 w-4"
                                        :class="getRarityColor(entry.root.rarity)"
                                    />
                                    <Check
                                        v-if="entry.root.is_default || hunterWeaponCount(entry.root)"
                                        class="absolute -bottom-1 -right-1 h-4 w-4 rounded-full bg-gray-300 text-primary-500 dark:bg-gray-900"
                                    />
                                </span>
                                <span class="mh-card-name">{{ entry.root.name }}</span>
                            </div>
                        </CraftWeaponModal>
                    </div>
                </div>

                <template
                    v-for="(path, row) in [sharedPath(entry), ...otherPaths(entry)]"
                    :key="path.branches.join()"
                >
                    <div
                        class="mh-branch-label col-start-1"
                        :style="{ gridRow: row + 1 }"
                    >
                        <span>{{ path.branches.join(' · ') }}</span>
                    </div>

                    <template
                        v-for="(weapon, step) in path.weapons"
                        :key="weapon.id"
                    >
                        <div
                            :class="[
                                linkClass(path, step, entry.root, weapon, row),
                                { 'mh-link-lit': isLit(weapon) },
                            ]"
                            :style="linkStyle(path, step, entry.root, weapon, row)"
                        />
                        <div
                            class="mh-target relative z-10"
                            :class="{ 'mh-target-lit': isLit(weapon) }"
                            :style="{ gridColumn: weapon.rarity + 1, gridRow: row + 1 }"
                            @mouseenter="light(weapon)"
                            @mouseleave="unlight"
                        >
                            <CraftWeaponModal
                                :campaign="campaign"
                                :hunter="hunter"
                                :weapon="weapon"
                                :class-container="isLit(weapon) ? 'mh-card-lit' : ''"
                            >
                                <div class="flex items-center gap-3">
                                    <span class="relative flex h-8 w-8 min-h-8 min-w-8 items-center justify-center rounded-full bg-gray-300 dark:bg-gray-900">
                                        <WeaponsIcon
                                            class="h-4 w-4"
                                            :class="getRarityColor(weapon.rarity)"
                                        />
                                        <!-- The count used to trail the name, which pushed a
                                             three word name onto a line the row has no room
                                             for. It reads as a badge instead, and a single
                                             one needs no number at all. -->
                                        <span
                                            v-if="hunterWeaponCount(weapon) > 1"
                                            class="absolute -bottom-1 -right-1 flex h-4 min-w-4 items-center justify-center rounded-full bg-gray-300 px-0.5 text-[0.6rem] font-bold leading-none text-primary-500 tabular-nums dark:bg-gray-900"
                                        >{{ hunterWeaponCount(weapon) }}</span>
                                        <Check
                                            v-else-if="weapon.is_default || hunterWeaponCount(weapon)"
                                            class="absolute -bottom-1 -right-1 h-4 w-4 rounded-full bg-gray-300 text-primary-500 dark:bg-gray-900"
                                        />
                                    </span>
                                    <span class="mh-card-name">{{ weapon.name }}</span>
                                </div>
                            </CraftWeaponModal>
                        </div>
                    </template>
                </template>
            </div>
        </div>
    </div>
</template>

<style>
@reference "../../../../css/app.css";

/* Rows are a fixed height so a row's centre is always half of it, which is what
   lets an elbow land on the box rather than near it. */
.mh-tree {
    /* A phone shows one column at a time whatever the width, so the tree is
       tightened there: narrower cards and shorter rows put a card and its
       neighbours on screen together instead of one card and a lot of wire. */
    --mh-col: 165px;
    /* Every owned weapon that is not the starting one carries two buttons, equip
       and craft, and measured they need 144px of card against the 111px one
       button needs. Anything shorter and the craft button hangs out through the
       bottom, which is what both 7rem here and 8rem below were doing. */
    --mh-row: 9.5rem;
    --mh-line: var(--color-gray-400);
    --mh-line-weight: 1px;
    grid-auto-rows: var(--mh-row);
}

@media (min-width: 640px) {
    .mh-tree {
        --mh-col: 220px;
        --mh-row: 9.5rem;
    }
}

.dark .mh-tree {
    --mh-line: var(--color-gray-600);
}

/* A connector is a grid item spanning the tiers between two boxes, so the line
   is whole however far apart they sit, with the head where it meets the card. */
.mh-link {
    @apply pointer-events-none relative self-center;
}

.mh-link::before {
    content: '';
    @apply absolute top-1/2 -translate-y-1/2;
    height: var(--mh-line-weight);
    background-color: var(--mh-line);
    left: -1.5rem;
    right: -1.5rem;
}

/* Sharing the target's column, so only the gap on its left is drawn. */
.mh-link-tight::before {
    left: -1.5rem;
    right: 100%;
}

.mh-target::before {
    content: '';
    @apply pointer-events-none absolute top-1/2 -left-1 z-10 h-0 w-0 -translate-y-1/2;
    @apply border-y-4 border-l-6 border-transparent border-l-gray-400 dark:border-l-gray-600;
}

.mh-target-lit::before {
    @apply border-l-primary-400 dark:border-l-primary-400;
}

/* A branch leaves the starting weapon downwards and turns to meet its own row,
   so every line can be traced back to the box it came out of. */
.mh-elbow {
    @apply pointer-events-none relative;
}

.mh-elbow::before {
    content: '';
    @apply absolute left-8;
    width: var(--mh-line-weight);
    background-color: var(--mh-line);
    top: calc(var(--mh-row) / 2);
    bottom: calc(var(--mh-row) / 2);
}

.mh-elbow::after {
    content: '';
    @apply absolute left-8;
    height: var(--mh-line-weight);
    background-color: var(--mh-line);
    right: -1.5rem;
    bottom: calc(var(--mh-row) / 2);
}

/* A lit line also thickens: a single pixel of brass on a near black panel is
   easy to miss, and the point of the highlight is to be followed at a glance. */
.mh-link-lit {
    --mh-line: var(--color-primary-400);
    --mh-line-weight: 2px;
}

/* Branch names run up the side, out of the way of the trunk and of the boxes,
   which is the only place they fit once every row is the same height. */
/* Lighting a path uses the same edge the game gives to what is already yours,
   one tone brighter so the two read apart. */
.mh-card-lit {
    @apply border-primary-400 dark:border-primary-400;
}
</style>
