export const DEFENSE_ELEMENTS = ['fire', 'water', 'thunder', 'ice', 'dragon'];

/**
 * What a set of pieces adds up to for one field. The tab's totals row and the
 * line in the sheet's header both ask, so the sum lives in one place.
 */
export function totalDefense(armors, field = 'defense') {
    return Object.values(armors ?? {})
        .reduce((sum, armor) => sum + (Number(armor?.[field]) || 0), 0);
}
