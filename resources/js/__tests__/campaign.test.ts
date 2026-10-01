import {describe, expect, it} from 'vitest';
import {hasBaseGame} from '@/campaign';

const options = [
    {key: 'ANCIENT_FOREST', label: 'Ancient Forest', base_game: true, extra_days: 0},
    {key: 'WILDSPIRE_WASTE', label: 'Wildspire Waste', base_game: true, extra_days: 0},
    {key: 'PICKING_BONES', label: 'Picking Bones Expansion', base_game: false, extra_days: 15},
];

describe('hasBaseGame', () => {
    it('is false with nothing ticked', () => {
        expect(hasBaseGame(options, [])).toBe(false);
    });

    it('is false with only add-ons ticked', () => {
        expect(hasBaseGame(options, ['PICKING_BONES'])).toBe(false);
    });

    it('is true with either box on its own', () => {
        expect(hasBaseGame(options, ['ANCIENT_FOREST'])).toBe(true);
        expect(hasBaseGame(options, ['WILDSPIRE_WASTE'])).toBe(true);
    });

    it('reads what counts as a base game off the options, not off a list of its own', () => {
        // The names come from `App\Enum\MonsterExpansion` through the page's
        // props, so a third base game is a PHP change and nothing here.
        const invented = [{key: 'A_THIRD_BOX', label: 'A third box', base_game: true, extra_days: 0}];

        expect(hasBaseGame(invented, ['A_THIRD_BOX'])).toBe(true);
    });

    it('ignores a selected key the options do not describe', () => {
        expect(hasBaseGame(options, ['A_BOX_THAT_WAS_RENAMED'])).toBe(false);
    });
});
