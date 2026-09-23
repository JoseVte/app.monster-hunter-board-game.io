import {describe, expect, it} from 'vitest';
import {equippedSkills} from '@/armorSkills';

const skill = (overrides = {}) => ({id: 1, bonus_set: false, bonus_set_armor: [], ...overrides});

describe('equippedSkills', () => {
    it('is empty with nothing worn', () => {
        expect(equippedSkills({})).toEqual([]);
        expect(equippedSkills(null)).toEqual([]);
    });

    it('reports the slot each skill came from', () => {
        const worn = {head: {id: 1, type_value: 'head', skills: [skill()]}};

        expect(equippedSkills(worn)[0].slot).toBe('head');
    });

    it('marks a plain skill active', () => {
        const worn = {head: {id: 1, type_value: 'head', skills: [skill()]}};

        expect(equippedSkills(worn)[0].active).toBe(true);
    });

    // The regression in 9c6b7d9: a set bonus needs every piece of its set worn.
    it('marks a set bonus active once every piece of the set is on', () => {
        const bonus = skill({bonus_set: true, bonus_set_armor: [1, 2]});
        const worn = {
            head: {id: 1, type_value: 'head', skills: [bonus]},
            body: {id: 2, type_value: 'body', skills: []},
        };

        expect(equippedSkills(worn)[0].active).toBe(true);
    });

    it('marks a set bonus inactive while a piece is missing', () => {
        const bonus = skill({bonus_set: true, bonus_set_armor: [1, 2, 3]});
        const worn = {head: {id: 1, type_value: 'head', skills: [bonus]}};

        expect(equippedSkills(worn)[0].active).toBe(false);
    });

    it('treats a piece with no skills as contributing none', () => {
        expect(equippedSkills({head: {id: 1, type_value: 'head'}})).toEqual([]);
    });
});
