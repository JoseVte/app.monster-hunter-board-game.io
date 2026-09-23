import {describe, expect, it} from 'vitest';
import {attackBreakdown, averageDamage} from '@/damage';

describe('attackBreakdown', () => {
    it('drops the values the weapon has no card for', () => {
        expect(attackBreakdown({count_attack_1: 0, count_attack_3: 2, count_attack_5: 1}))
            .toEqual([{value: 3, count: 2}, {value: 5, count: 1}]);
    });

    it('treats a missing field as no cards', () => {
        expect(attackBreakdown({})).toEqual([]);
    });

    it('survives a null weapon', () => {
        expect(attackBreakdown(null)).toEqual([]);
    });
});

describe('averageDamage', () => {
    it('weights each value by how many cards carry it', () => {
        // Three 1s and one 5: (3 + 5) / 4 = 2.
        expect(averageDamage({count_attack_1: 3, count_attack_5: 1})).toBe(2);
    });

    it('rounds to one decimal', () => {
        // Two 1s and one 2: 4 / 3 = 1.333...
        expect(averageDamage({count_attack_1: 2, count_attack_2: 1})).toBe(1.3);
    });

    it('is zero rather than NaN for a weapon with no cards', () => {
        expect(averageDamage({})).toBe(0);
    });
});
