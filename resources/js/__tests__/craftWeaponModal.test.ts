import {afterEach, beforeEach, describe, expect, it, vi} from 'vitest';
import type {MockInstance} from 'vitest';
import {flushPromises} from '@vue/test-utils';
import {router} from '@inertiajs/vue3';
import {mountComponent} from './setup';
import CraftWeaponModal from '@/Pages/Hunter/Partials/CraftWeaponModal.vue';

// The craft dialog of a weapon card: which recipe it spends, what the whole
// missing line still costs, and which of equip, unequip and craft it offers.
// The server has the last word on all of it (`CraftWithSeveralRecipesTest`,
// `WeaponChainCostTest`), but what the dialog shows is what a player decides on.

const part = (id: number, name: string, number: number) => ({id, name, pivot: {number}});
const held = (id: number, number: number) => ({id, pivot: {item_id: id, hunter_id: 7, number}});

const type = {id: 1, name: 'Great Sword', image_url: '/gs.svg'};

const weapon = (extra: Record<string, unknown> = {}) => ({
    id: 50,
    type_id: 1,
    type,
    name: 'Flammenschwert',
    rarity: 3,
    is_default: false,
    equipped: null,
    parent: null,
    count_attack_1: 1,
    count_attack_2: 0,
    count_attack_3: 0,
    count_attack_4: 0,
    count_attack_5: 0,
    status_attacks: [],
    recipes: [
        {id: 1, branch: 'Anjanath', items: [part(1, 'Anjanath Fang', 2), part(2, 'Monster Bone', 1)]},
        {id: 2, branch: 'Rathalos', items: [part(3, 'Rathalos Scale', 3)]},
    ],
    craftable_recipes: [2],
    can_craft: true,
    missing_chain: [],
    chain_items: [],
    ...extra,
});

const hunter = {id: 7, items: [held(1, 1), held(2, 5), held(3, 3)], weapons: [] as Array<{id: number}>};

let post: MockInstance<typeof router.post>;
let put: MockInstance<typeof router.put>;

beforeEach(() => {
    post = vi.spyOn(router, 'post').mockImplementation(() => undefined);
    put = vi.spyOn(router, 'put').mockImplementation(() => undefined);
    document.body.innerHTML = '';
});

afterEach(() => {
    vi.restoreAllMocks();
});

const open = async (props: Record<string, unknown>) => {
    const wrapper = mountComponent(CraftWeaponModal, {campaign: {id: 1}, hunter, ...props});
    const craft = wrapper.findAll('button').find((button) => button.text().includes('Craft'))!;

    await craft.trigger('click');
    await flushPromises();

    return wrapper;
};

const tableRows = () => [...document.querySelectorAll('tbody tr')]
    .map((row) => [...row.querySelectorAll('td')].map((cell) => cell.textContent?.trim()));

const recipeButton = (branch: string) => [...document.querySelectorAll<HTMLButtonElement>('button')]
    .find((button) => button.textContent?.trim().startsWith(branch))!;

describe('CraftWeaponModal.vue', () => {
    it('starts on the first recipe the hunter can afford, not the first listed', async () => {
        await open({weapon: weapon()});

        expect(tableRows()).toEqual([['Rathalos Scale', '3', '3']]);
    });

    it('spends the recipe the player picked', async () => {
        await open({weapon: weapon({craftable_recipes: [1, 2]})});

        recipeButton('Rathalos').click();
        await flushPromises();
        expect(tableRows()).toEqual([['Rathalos Scale', '3', '3']]);

        document.querySelector<HTMLButtonElement>('#craft-weapon-btn')!.click();
        await flushPromises();

        expect(post).toHaveBeenCalledTimes(1);
        expect(post.mock.calls[0][0]).toBe('/campaigns.hunters.weapons.craft');
        expect(post.mock.calls[0][1]).toEqual({recipe: 2});
        expect(post.mock.calls[0][2]).toMatchObject({errorBag: 'craftWeaponHunter'});
    });

    it('marks a recipe the hunter cannot afford and the part they are short of', async () => {
        await open({weapon: weapon()});

        expect(recipeButton('Anjanath').textContent).toContain('·');
        expect(recipeButton('Rathalos').textContent).not.toContain('·');

        recipeButton('Anjanath').click();
        await flushPromises();

        expect(tableRows()).toEqual([['Anjanath Fang', '2', '1'], ['Monster Bone', '1', '5']]);
        expect([...document.querySelectorAll('tbody td.text-red-500')].map((cell) => cell.textContent?.trim())).toEqual(['1']);
    });

    it('adds the missing line to the bill and judges what is short against that total', async () => {
        await open({
            weapon: weapon({
                recipes: [{id: 1, branch: 'Anjanath', items: [part(1, 'Anjanath Fang', 1)]}],
                craftable_recipes: [],
                can_craft: false,
                parent: {id: 49, name: 'Anja Buster'},
                missing_chain: [{id: 49, name: 'Anja Buster'}],
                chain_items: [{id: 1, name: 'Anjanath Fang', number: 2}, {id: 2, name: 'Monster Bone', number: 6}],
            }),
        });

        expect(document.body.textContent).toContain('Accumulated total');
        expect(document.body.textContent).toContain('Anja Buster');

        // The weapon it upgrades from first, which the hunter does not hold, then
        // one row per part: the fang this step asks for plus the chain's, and the
        // bone only the chain needs, which has no number for this step.
        expect(tableRows()).toEqual([
            ['Anja Buster', '1', '', '0'],
            ['Anjanath Fang', '1', '3', '1'],
            ['Monster Bone', '—', '6', '5'],
        ]);
        // Five bones against a bill of six is short, though this step alone
        // asks for none.
        expect([...document.querySelectorAll('tbody td.text-red-500')].map((cell) => cell.textContent?.trim())).toEqual(['0', '1', '5']);

        const craft = [...document.querySelectorAll<HTMLButtonElement>('button')].filter((button) => button.textContent?.trim() === 'Craft').at(-1)!;
        expect(craft.disabled).toBe(true);
    });

    it('offers only the equip button for a starting weapon not in hand', () => {
        const wrapper = mountComponent(CraftWeaponModal, {campaign: {id: 1}, hunter, weapon: weapon({is_default: true})});

        expect(wrapper.findAll('button').map((button) => button.text())).toEqual(['Equip']);
    });

    it('cannot take off a starting weapon that is in hand', () => {
        const wrapper = mountComponent(CraftWeaponModal, {campaign: {id: 1}, hunter, weapon: weapon({is_default: true, equipped: {id: 50}})});

        const buttons = wrapper.findAll('button');
        expect(buttons.map((button) => button.text())).toEqual(['Equipped']);
        expect(buttons[0].attributes('disabled')).toBeDefined();
    });

    it('equips an owned weapon and takes an equipped one off', async () => {
        const owner = {...hunter, weapons: [{id: 50}]};

        const owned = mountComponent(CraftWeaponModal, {campaign: {id: 1}, hunter: owner, weapon: weapon()});
        await owned.findAll('button')[0].trigger('click');
        expect(put.mock.calls[0][1]).toEqual({equip: true});

        const equipped = mountComponent(CraftWeaponModal, {campaign: {id: 1}, hunter: owner, weapon: weapon({equipped: {id: 50}})});
        await equipped.findAll('button')[0].trigger('click');
        expect(put.mock.calls[1][1]).toEqual({equip: false});
        expect(put.mock.calls[1][2]).toMatchObject({errorBag: 'unequipWeaponHunter'});
    });

    it('shows nothing to act on in the wiki, where there is no hunter', () => {
        const wrapper = mountComponent(CraftWeaponModal, {campaign: null, hunter: null, weapon: weapon()});

        expect(wrapper.findAll('button')).toHaveLength(0);
    });
});
