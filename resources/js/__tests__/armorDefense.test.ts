import {describe, expect, it} from 'vitest';
import {ARMOR_SLOTS, DEFENSE_ELEMENTS, totalDefense, weaponDefense} from '@/armorDefense';

describe('totalDefense', () => {
    it('sums the named field across every worn piece', () => {
        expect(totalDefense({head: {defense: 3}, body: {defense: 4}})).toBe(7);
    });

    it('sums an element instead when asked', () => {
        expect(totalDefense({head: {fire: 2}, body: {fire: -1}}, 'fire')).toBe(1);
    });

    it('counts a non numeric value as zero rather than producing NaN', () => {
        expect(totalDefense({head: {defense: null}, body: {defense: 2}})).toBe(2);
    });

    it('is zero for no pieces at all', () => {
        expect(totalDefense(null)).toBe(0);
    });
});

// `defaultArmor` is `WeaponType.default_armor`: an object keyed by slot name to
// how many points it grants there (see WeaponsSeeder, e.g. `{head: 0, body: 0,
// leg: 1}`), not `{type_value: 'head'}`. With the brief's original guess, every
// lookup in `weaponDefense` comes back `undefined` regardless of what is worn:
// "does not stack" would have passed anyway, but for the wrong reason (it stays
// zero because nothing was ever granted, not because the worn piece cancelled
// the grant), while "counts while that slot is empty" would have failed
// outright (it expects 1 and gets 0 the same way). The shape was wrong either
// way.
describe('weaponDefense', () => {
    it('is zero without a default armor grant', () => {
        expect(weaponDefense({}, null)).toBe(0);
    });

    it('does not stack with a piece worn in the slot it grants', () => {
        const defaultArmor = {head: 1, body: 0, leg: 0};
        const armors = {head: {type_value: 'head'}};

        expect(weaponDefense(armors, defaultArmor)).toBe(0);
    });

    it('counts while that slot is empty', () => {
        const defaultArmor = {head: 1, body: 0, leg: 0};
        const armors = {body: {type_value: 'body'}};

        expect(weaponDefense(armors, defaultArmor)).toBe(1);
    });
});

describe('the constants', () => {
    it('names the five elements in card order', () => {
        expect(DEFENSE_ELEMENTS).toEqual(['fire', 'water', 'thunder', 'ice', 'dragon']);
    });

    it('names the three slots', () => {
        expect(ARMOR_SLOTS).toEqual(['head', 'body', 'leg']);
    });
});
