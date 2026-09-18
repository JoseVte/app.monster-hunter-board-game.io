import fire from '~/types/fire.png';
import water from '~/types/water.png';
import thunder from '~/types/thunder.png';
import ice from '~/types/ice.png';
import dragon from '~/types/dragon.png';
import damageAttack from '~/icons/damage-attack.png';
import comboAttack from '~/icons/combo-attack.png';
import defense from '~/icons/defense.png';
import breakIcon from '~/icons/break.svg';
import poison from '~/icons/poison.webp';
import stun from '~/icons/stun.webp';
import sleep from '~/icons/sleep.svg';

// The seed data marks a game symbol as :name_icon:. Everything with artwork
// lives here; anything else falls back to a placeholder rather than printing the
// raw token, which is what used to happen to four of them.
const icons = {
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
};

// Names the placeholder announces. The surrounding sentence usually already says
// the word ("the Axe :switch_axe_axe_icon:"), so the badge shows a symbol rather
// than repeating it, and the full name goes in the tooltip.
const pending = {
    deviation_icon: 'Deviation',
    deviation_icon_none: 'No deviation',
    deviation_icon_low: 'Low deviation',
    deviation_icon_average: 'Average deviation',
    deviation_icon_high: 'High deviation',
    lance_icon: 'Lance',
    switch_axe_axe_icon: 'Axe mode',
    switch_axe_sword_icon: 'Sword mode',
    charge_hammer_icon_1: 'Charge 1',
    charge_hammer_icon_2: 'Charge 2',
    charged_blade_vial: 'Vial',
    damage_card_icon: 'Damage card',
    shelling_up_icon: 'Shelling',
    charged_blade_vial_plus: 'Vial plus',
    kinsect_icon_1: 'Kinsect 1',
    kinsect_icon_2: 'Kinsect 2',
    kinsect_icon_3: 'Kinsect 3',
};

// Not every token ends in `_icon`: the data also writes :charged_blade_vial:,
// :kinsect_icon_1: and :deviation_icon_high:, which a pattern anchored on that
// suffix silently walked past.
const TOKEN = /:([a-z0-9_]+):/g;

function humanise(name) {
    return name.replace(/_/g, ' ').replace(/^./, (first) => first.toUpperCase());
}

// The name comes from the capture group, which the pattern limits to lowercase,
// digits and underscores, so nothing user supplied can reach the markup.
function placeholder(name) {
    const label = pending[name] ?? humanise(name);

    return `<span class="inline-block px-1 text-[0.65rem] font-semibold leading-4 align-middle rounded border border-current opacity-70" title="${label}">${label}</span>`;
}

export function replaceIcons(text) {
    if (typeof text !== 'string') {
        return text;
    }

    return text.replaceAll(TOKEN, (match, name) => {
        const icon = icons[name];

        return icon
            ? `<img src="${icon.src}" alt="${icon.alt}" title="${icon.alt}" class="h-4 w-4 inline">`
            : placeholder(name);
    });
}

export const iconNames = Object.keys(icons);
export const pendingIconNames = Object.keys(pending);
