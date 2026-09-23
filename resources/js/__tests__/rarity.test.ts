import {describe, expect, it} from 'vitest';
import {getRarityColor} from '@/rarity';

describe('getRarityColor', () => {
    it('maps each rarity to its own class', () => {
        expect(getRarityColor(1)).toBe('text-gray-400 dark:text-gray-300');
        expect(getRarityColor(2)).toBe('text-lime-600');
        expect(getRarityColor(3)).toBe('text-green-600');
        expect(getRarityColor(4)).toBe('text-blue-500');
        expect(getRarityColor(5)).toBe('text-orange-500');
    });

    it('falls back to plain text for an unknown rarity', () => {
        expect(getRarityColor(99)).toBe('text-black dark:text-white');
        expect(getRarityColor(undefined)).toBe('text-black dark:text-white');
    });
});
