export const DEFENSE_ELEMENTS = ['fire', 'water', 'thunder', 'ice', 'dragon'];

/**
 * What a set of pieces adds up to for one field. The tab's totals row and the
 * line in the sheet's header both ask, so the sum lives in one place.
 */
export function totalDefense(armors, field = 'defense') {
    return Object.values(armors ?? {})
        .reduce((sum, armor) => sum + (Number(armor?.[field]) || 0), 0);
}

export const ARMOR_SLOTS = ['head', 'body', 'leg'];

/**
 * What the weapon in hand is worth as armour. Each type grants a point in one
 * slot, and only while nothing of the hunter's own is worn there, so a piece
 * put on replaces it rather than stacking with it.
 */
export function weaponDefense(armors, defaultArmor) {
    if (! defaultArmor) {
        return 0;
    }

    const worn = new Set(Object.values(armors ?? {}).map((armor) => armor?.type_value));

    return ARMOR_SLOTS.reduce(
        (sum, slot) => sum + (worn.has(slot) ? 0 : (Number(defaultArmor[slot]) || 0)),
        0,
    );
}
