// A weapon card prints how many attack cards of each damage value the weapon
// brings, which is what `count_attack_1` through `count_attack_5` hold. The
// zeroes among them mean the weapon has no card of that value, not a card worth
// nothing, so they are left out rather than drawn as an empty slot.
export function attackBreakdown(weapon) {
    return [1, 2, 3, 4, 5]
        .map((value) => ({value, count: weapon?.[`count_attack_${value}`] ?? 0}))
        .filter(({count}) => count > 0);
}

// What one card off the top is worth, which is the number that compares two
// weapons: a wide spread of cheap cards can still beat a single heavy one, and
// counting the cards alone says nothing about that.
export function averageDamage(weapon) {
    const breakdown = attackBreakdown(weapon);
    const cards = breakdown.reduce((total, {count}) => total + count, 0);

    if (! cards) {
        return 0;
    }

    const damage = breakdown.reduce((total, {value, count}) => total + (value * count), 0);

    return Math.round((damage / cards) * 10) / 10;
}
