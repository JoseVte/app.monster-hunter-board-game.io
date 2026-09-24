import fire from '~/types/fire.png';
import water from '~/types/water.png';
import thunder from '~/types/thunder.png';
import ice from '~/types/ice.png';
import dragon from '~/types/dragon.png';
import damageAttack from '~/icons/damage-icon.png';
import comboAttack from '~/icons/combo-icon.png';
import defense from '~/icons/defense-icon.png';
import breakIcon from '~/icons/break-icon.png';
import poison from '~/icons/poison.webp';
import stun from '~/icons/stun.webp';
import sleep from '~/icons/sleep.svg';
import paralysis from '~/icons/paralysis.png';
import nitro from '~/icons/nitro.png';
import movement from '~/icons/movement-icon.png';
import dodge from '~/icons/dodge-icon.png';
import range from '~/icons/range-icon.png';
import hunterBehaviour from '~/icons/hunter-behaviour-icon.png';
import dodgeMonster from '~/icons/dodge-monster-icon.png';
import damageMonster from '~/icons/damage-monster-icon.png';
import attackNode from '~/icons/attack-node-icon.png';
import fireMonsterDamage from '~/icons/fire-monster-damage-icon.png';
import headImg from '~/monster-parts/head.png';
import backImg from '~/monster-parts/back.png';
import clawImg from '~/monster-parts/claw.png';
import tailImg from '~/monster-parts/tail.png';
import legImg from '~/monster-parts/leg.png';
import wingImg from '~/monster-parts/wing.png';
import pawImg from '~/monster-parts/paw.png';
import cardBehaviour from '~/icons/card-behaviour-icon.png';
import nearHunter from '~/icons/near-hunter-icon.png';
import farHunter from '~/icons/far-hunter-icon.png';
import bushMap from '~/icons/bush-map-icon.png';
import rockMap from '~/icons/rock-map-icon.png';
import mudMap from '~/icons/mud-map-icon.png';
import deviationNone from '~/icons/deviation-none-icon.png';
import deviationLow from '~/icons/deviation-low-icon.png';
import deviationAverage from '~/icons/deviation-average-icon.png';
import deviationHigh from '~/icons/deviation-high-icon.png';
import switchAxeAxe from '~/icons/switch-axe-axe-icon.png';
import switchAxeSword from '~/icons/switch-axe-sword-icon.png';
import deviation from '~/icons/deviation-icon.png';
import lanceSymbol from '~/icons/lance-icon.png';
import vial from '~/icons/charged-blade-vial-icon.png';
import vialPlus from '~/icons/charged-blade-vial-plus-icon.png';
import kinsectOne from '~/icons/kinsect-1-icon.png';
import kinsectTwo from '~/icons/kinsect-2-icon.png';
import kinsectThree from '~/icons/kinsect-3-icon.png';

type Icon = {src: string, alt: string};
type Resistance = Icon & {element: string};

// The seed data marks a game symbol as :name_icon:. Everything with artwork
// lives here; anything else falls back to a placeholder rather than printing the
// raw token, which is what used to happen to four of them.
const icons: Record<string, Icon> = {
    fire_icon: { src: fire, alt: 'Fire' },
    water_icon: { src: water, alt: 'Water' },
    ice_icon: { src: ice, alt: 'Ice' },
    thunder_icon: { src: thunder, alt: 'Thunder' },
    dragon_icon: { src: dragon, alt: 'Dragon' },
    damage_attack_icon: { src: damageAttack, alt: 'Damage attack' },
    combo_attack_icon: { src: comboAttack, alt: 'Combo attack' },
    defense_icon: { src: defense, alt: 'Defense' },
    break_icon: { src: breakIcon, alt: 'Break' },
    poison_icon: { src: poison, alt: 'Poison' },
    stun_icon: { src: stun, alt: 'Stun' },
    sleep_icon: { src: sleep, alt: 'Sleep' },
    // The symbol printed on the lance's attack cards, which is its own drawing
    // rather than the silhouette the seeder ships as the weapon type image.
    lance_icon: { src: lanceSymbol, alt: 'Lance' },
    paralysis_icon: { src: paralysis, alt: 'Paralysis' },
    nitro_icon: { src: nitro, alt: 'Nitro' },
    // Monster mechanics text calls this effect "blast" where weapon text calls
    // it "nitro", the same game symbol either way.
    blast_icon: { src: nitro, alt: 'Nitro' },
    // Likewise "damage" and "damage attack" are the same symbol under two names.
    damage_icon: { src: damageAttack, alt: 'Damage attack' },
    movement_icon: { src: movement, alt: 'Movement' },
    dodge_icon: { src: dodge, alt: 'Dodge' },
    range_icon: { src: range, alt: 'Range' },
    hunter_behaviour_icon: { src: hunterBehaviour, alt: 'Hunter behaviour' },
    dodge_monster_icon: { src: dodgeMonster, alt: 'Dodge monster' },
    damage_monster_icon: { src: damageMonster, alt: 'Damage to monster' },
    attack_node_icon: { src: attackNode, alt: 'Attack node' },
    fire_monster_damage_icon: { src: fireMonsterDamage, alt: 'Fire monster damage' },
    // Same pictograms MonsterPartBox uses for a part's structured display,
    // reused here so the same body part named inline in ability/mechanics
    // text (e.g. ":head_icon:") renders the icon instead of a placeholder.
    head_icon: { src: headImg, alt: 'Head' },
    back_icon: { src: backImg, alt: 'Back' },
    claw_icon: { src: clawImg, alt: 'Claw' },
    tail_icon: { src: tailImg, alt: 'Tail' },
    leg_icon: { src: legImg, alt: 'Leg' },
    wing_icon: { src: wingImg, alt: 'Wing' },
    paw_icon: { src: pawImg, alt: 'Paw' },
    card_behaviour_icon: { src: cardBehaviour, alt: 'Behaviour card' },
    near_hunter_icon: { src: nearHunter, alt: 'Near hunter' },
    far_hunter_icon: { src: farHunter, alt: 'Far hunter' },
    bush_map_icon: { src: bushMap, alt: 'Bush' },
    rock_map_icon: { src: rockMap, alt: 'Rock' },
    mud_map_icon: { src: mudMap, alt: 'Mud' },
    // The bare token is the deviation symbol itself, with no rating attached.
    // The four below are a different drawing, the one the rulebook colours to
    // tell the ratings apart.
    deviation_icon: { src: deviation, alt: 'Deviation' },
    deviation_icon_none: { src: deviationNone, alt: 'No deviation' },
    deviation_icon_low: { src: deviationLow, alt: 'Low deviation' },
    deviation_icon_average: { src: deviationAverage, alt: 'Average deviation' },
    deviation_icon_high: { src: deviationHigh, alt: 'High deviation' },
    // The two modes a switch axe fights in, which is what its attack deck is
    // split by. The drawing is a white silhouette, so both carry the dark
    // backing the artwork came with; without it they are invisible in light
    // mode, which is where they would be read most.
    switch_axe_axe_icon: { src: switchAxeAxe, alt: 'Axe mode' },
    switch_axe_sword_icon: { src: switchAxeSword, alt: 'Sword mode' },
    charged_blade_vial: { src: vial, alt: 'Vial' },
    charged_blade_vial_plus: { src: vialPlus, alt: 'Vial plus' },
    // One bug in three colours. As drawn they were three different bugs in a
    // salmon and an orange near enough to read as the same at 16px.
    kinsect_icon_1: { src: kinsectOne, alt: 'Kinsect 1' },
    kinsect_icon_2: { src: kinsectTwo, alt: 'Kinsect 2' },
    kinsect_icon_3: { src: kinsectThree, alt: 'Kinsect 3' },
};

// A resistance is the element's symbol on a pentagon, the way the board prints
// it. Only thunder appears in the data today, but the card carries all five and
// they are drawn the same way, so the set is complete rather than one-off.
export const resistances: Record<string, Resistance> = {
    fire_resistance_icon: { src: fire, alt: 'Fire resistance', element: 'fire' },
    water_resistance_icon: { src: water, alt: 'Water resistance', element: 'water' },
    ice_resistance_icon: { src: ice, alt: 'Ice resistance', element: 'ice' },
    thunder_resistance_icon: { src: thunder, alt: 'Thunder resistance', element: 'thunder' },
    dragon_resistance_icon: { src: dragon, alt: 'Dragon resistance', element: 'dragon' },
};

// A regular pentagon, point up, inscribed in the 20x20 box at radius 9.
export const PENTAGON = '10,1 18.56,7.22 15.29,17.28 4.71,17.28 1.44,7.22';

function resistance({ src, alt, element }: Resistance): string {
    return `<span class="mh-resistance mh-resistance-${element} relative inline-flex h-5 w-5 shrink-0 items-center justify-center align-text-bottom" title="${alt}">`
        + `<svg viewBox="0 0 20 20" class="absolute inset-0 h-full w-full" aria-hidden="true">`
        + `<polygon points="${PENTAGON}"></polygon>`
        + `</svg>`
        + `<img src="${src}" alt="${alt}" class="relative h-3 w-3">`
        + `</span>`;
}

// Names the placeholder announces. The surrounding sentence usually already says
// the word ("+1 :damage_attack_icon: for every :charged_blade_vial:"), so the
// badge shows a symbol rather than repeating it, and the full name goes in the
// tooltip.
const pending: Record<string, string> = {
    charge_hammer_icon_1: 'Charge 1',
    charge_hammer_icon_2: 'Charge 2',
    shelling_up_icon: 'Shelling',
    // Monster ability, mechanics and reward text, now seeded, carries these.
    investigation_behaviour_icon: 'Investigation behaviour',
};

// Not every token ends in `_icon`: the data also writes :charged_blade_vial:,
// :kinsect_icon_1: and :deviation_icon_high:, which a pattern anchored on that
// suffix silently walked past.
const TOKEN = /:([a-z0-9_]+):/g;

function humanise(name: string): string {
    return name.replace(/_/g, ' ').replace(/^./, (first) => first.toUpperCase());
}

// The name comes from the capture group, which the pattern limits to lowercase,
// digits and underscores, so nothing user supplied can reach the markup.
function placeholder(name: string): string {
    const label = pending[name] ?? humanise(name);

    return `<span class="inline-block px-1 text-[0.65rem] font-semibold leading-4 align-middle rounded border border-current opacity-70" title="${label}">${label}</span>`;
}

// Real callers pass a plain `string`, a nullable model field typed
// `string | null` (most description columns), or a value already guarded with
// `| undefined`; a single union covers all three rather than enumerating them
// as overloads, which is what missed `string | null` the first time round.
// `null`/`undefined` pass straight through unchanged, which is what the short
// circuit below does at runtime for anything that is not a string.
export function replaceIcons(text: string | null | undefined): string | null | undefined {
    if (typeof text !== 'string') {
        return text;
    }

    return text.replaceAll(TOKEN, (match, name) => {
        if (resistances[name]) {
            return resistance(resistances[name]);
        }

        const icon = icons[name];

        return icon
            ? `<img src="${icon.src}" alt="${icon.alt}" title="${icon.alt}" class="h-4 w-4 inline">`
            : placeholder(name);
    });
}

// Some things a weapon carries are not written as `:tokens:` at all: its
// element and the statuses it inflicts are plain names in the seed data, and the
// panel that shows them wants the artwork at its own size rather than the 16px
// `replaceIcons` hands back.
export function iconFor(name: string): Icon | null {
    return icons[name] ?? null;
}

export const iconNames: Array<string> = Object.keys(icons).concat(Object.keys(resistances));
export const pendingIconNames: Array<string> = Object.keys(pending);
