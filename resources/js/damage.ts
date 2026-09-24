// A weapon card prints how many attack cards of each damage value the weapon
// brings, which is what `count_attack_1` through `count_attack_5` hold. The
// zeroes among them mean the weapon has no card of that value, not a card worth
// nothing, so they are left out rather than drawn as an empty slot.

// Both functions here only ever read the five `count_attack_*` columns, never
// the rest of a weapon, and the tests exercise them with bare `{count_attack_1:
// ...}` objects rather than a full `App.Models.Weapon`. Typing the parameter as
// the whole model would reject those calls outright, so it is a pick of the
// columns actually used instead.
type AttackCounts = Partial<Pick<
    App.Models.Weapon,
    'count_attack_1' | 'count_attack_2' | 'count_attack_3' | 'count_attack_4' | 'count_attack_5'
>>;

export function attackBreakdown(weapon?: AttackCounts | null): Array<{value: number; count: number}> {
    return [1, 2, 3, 4, 5]
        .map((value) => ({value, count: weapon?.[`count_attack_${value}` as keyof AttackCounts] ?? 0}))
        .filter(({count}) => count > 0);
}

// What one card off the top is worth, which is the number that compares two
// weapons: a wide spread of cheap cards can still beat a single heavy one, and
// counting the cards alone says nothing about that.
export function averageDamage(weapon?: AttackCounts | null): number {
    const breakdown = attackBreakdown(weapon);
    const cards = breakdown.reduce((total, {count}) => total + count, 0);

    if (! cards) {
        return 0;
    }

    const damage = breakdown.reduce((total, {value, count}) => total + (value * count), 0);

    return Math.round((damage / cards) * 10) / 10;
}
