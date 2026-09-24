<script setup lang="ts">
import {replaceIcons} from "@/icons";
import headImg from "~/monster-parts/head.png";
import backImg from "~/monster-parts/back.png";
import clawImg from "~/monster-parts/claw.png";
import tailImg from "~/monster-parts/tail.png";
import legImg from "~/monster-parts/leg.png";
import wingImg from "~/monster-parts/wing.png";
import pawImg from "~/monster-parts/paw.png";
import PositionMarker from "@/Components/Icons/PositionMarker.vue";
import ShieldIcon from "@/Components/Icons/ShieldIcon.vue";
import BrokenPartIcon from "@/Components/Icons/BrokenPartIcon.vue";

defineProps<{
    part: App.Models.MonsterPart;
}>();

// A generic pictogram per part, original to this app rather than the
// physical card's own art (which draws one whole-body silhouette per
// monster, not a named icon per part).
type PartIconKey = 'head' | 'back' | 'claw' | 'tail' | 'leg' | 'wing' | 'paw';

const PART_ICONS: Record<PartIconKey, string> = {
    head: headImg,
    back: backImg,
    claw: clawImg,
    tail: tailImg,
    leg: legImg,
    wing: wingImg,
    paw: pawImg,
};

// `MonsterPart.icon` is a plain string off the model, not the literal union
// above, so it is checked against the map's own keys rather than cast into
// it. `in` walks the prototype chain, so `'toString' in PART_ICONS` is `true`
// and this would wrongly accept it; `Object.hasOwn` checks the object's own
// keys only. Matches `WeaponStats.vue`'s `isDeviationKey` guard.
const isPartIconKey = (key: string): key is PartIconKey => Object.hasOwn(PART_ICONS, key);

const partIcon = (icon: string): string | undefined => (isPartIconKey(icon) ? PART_ICONS[icon] : undefined);
</script>

<template>
    <div class="mh-value flex max-w-60 flex-col gap-1 p-2 text-center">
        <div class="flex items-center gap-2">
            <div class="flex shrink-0 flex-col items-center gap-1">
                <img
                    v-if="partIcon(part.icon)"
                    :src="partIcon(part.icon)"
                    :alt="part.icon"
                    class="h-10 w-10 shrink-0 object-contain"
                >
            </div>
            <PositionMarker
                :direction="part.direction"
                class="h-20 w-20 shrink-0 text-gray-400 dark:text-gray-600"
            />
            <div class="flex flex-col items-center gap-1">
                <span class="flex items-center gap-1">
                    <ShieldIcon class="h-10 w-10" />
                    <span>{{ part.defense }}</span>
                </span>
                <span class="flex items-center gap-1">
                    <BrokenPartIcon class="h-10 w-10 text-gray-500 dark:text-gray-400" />
                    <span>{{ part.broken }}</span>
                </span>
            </div>
        </div>
        <p
            v-if="part.ability_broken"
            class="text-xs font-normal text-gray-600 italic dark:text-gray-400"
            v-html="replaceIcons(part.ability_broken)"
        />
    </div>
</template>
