import {afterEach, beforeEach, describe, expect, it, vi} from 'vitest';
import type {MockInstance} from 'vitest';
import {flushPromises} from '@vue/test-utils';
import {router} from '@inertiajs/vue3';
import {mountComponent} from './setup';
import Show from '@/Pages/Hunter/Show.vue';
import AddItemToHunterButton from '@/Pages/Hunter/Partials/AddItemToHunterButton.vue';
import GridItemHunter from '@/Pages/Hunter/Partials/GridItemHunter.vue';
import ArmorBranchGrid from '@/Pages/Hunter/Partials/ArmorBranchGrid.vue';
import ArmorCard from '@/Pages/Hunter/Partials/ArmorCard.vue';
import ListArmorType from '@/Pages/Hunter/Partials/ListArmorType.vue';
import ListWeaponTypes from '@/Pages/Hunter/Partials/ListWeaponTypes.vue';
import CraftArmorModal from '@/Pages/Hunter/Partials/CraftArmorModal.vue';
import ActiveSkills from '@/Pages/Hunter/Partials/ActiveSkills.vue';

// The hunter sheet, mounted whole the way `CampaignHunterController::show()`
// hands it over. Nothing mounted it before, so the decisions it makes about
// what a reader sees (which weapon they carry, who may edit, which armour
// layout fits the screen, which pieces are worth drawing) went unchecked.

const greatSword = {
    id: 1,
    name: 'Great Sword',
    image_url: '/gs.svg',
    default_armor: {head: 1, body: 2, leg: 1},
    weapons: [
        {id: 10, type_id: 1, name: 'Buster Sword', is_default: true},
        {id: 11, type_id: 1, name: 'Anja Buster', is_default: false},
    ],
};
const bow = {
    id: 2,
    name: 'Bow',
    image_url: '/bow.svg',
    default_armor: null,
    weapons: [{id: 20, type_id: 2, name: 'Hunter\'s Bow', is_default: true}],
};

const skill = (id: number, name: string, bonusSetArmor: number[] | null = null) => ({
    id,
    name,
    description: `${name} description`,
    bonus_set: bonusSetArmor !== null,
    bonus_set_armor: bonusSetArmor,
});

const piece = (id: number, slot: 'head' | 'body' | 'leg', branch: string, extra: Record<string, unknown> = {}) => ({
    id,
    name: `${branch} ${slot}`,
    type_value: slot,
    branch,
    rarity: 2,
    is_default: false,
    defense: 1,
    defense_fire: 0,
    defense_water: 0,
    defense_thunder: 0,
    defense_ice: 0,
    defense_dragon: 0,
    skills: [],
    items: [],
    ...extra,
});

const anjaHead = piece(100, 'head', 'Anjanath', {skills: [skill(1, 'Fire Attack')], equipped: true});
const anjaBody = piece(101, 'body', 'Anjanath', {skills: [skill(2, 'Anjanath Will', [100, 101, 102])]});
const anjaLeg = piece(102, 'leg', 'Anjanath');
const rathHead = piece(200, 'head', 'Rathalos');

const armors = {
    Anjanath: {head: anjaHead, body: anjaBody, leg: anjaLeg},
    Rathalos: {head: rathHead},
};

const item = (id: number, name: string) => ({id, name});
const held = (id: number, name: string, number: number) => ({id, name, pivot: {item_id: id, hunter_id: 7, number}});

const baseHunter = {
    id: 7,
    name: 'Aloy',
    campaign_id: 1,
    weapon_type_id: 1,
    weapon_type: greatSword,
    palico: {id: 1, name: 'Meowscular'},
    items: [held(1, 'Monster Bone', 3)],
    other_items: [held(31, 'Zeta', 1), held(30, 'Alpha', 2)],
    monster_items: [held(41, 'Rathalos Scale', 1), held(40, 'Anjanath Fang', 1)],
    weapons: [{id: 11, type_id: 1, name: 'Anja Buster'}],
    equipped_weapons: [] as Array<Record<string, unknown>>,
    armors: [anjaHead],
    equipped_armors: [anjaHead],
};

const props = (overrides: Record<string, unknown> = {}, hunter: Record<string, unknown> = {}) => ({
    canEdit: true,
    campaign: {id: 1, name: 'Iceborne Crew'},
    hunter: {...baseHunter, ...hunter},
    tabOpened: 'items',
    weaponType: null,
    weapons: [],
    armors,
    user: {id: 1, name: 'Test Hunter', profile_photo_url: '/me.png'},
    commonItems: [item(1, 'Monster Bone'), item(2, 'Iron Ore')],
    otherItems: [item(30, 'Alpha'), item(31, 'Zeta')],
    monsterItems: [{monster: 'Anjanath', items: [item(40, 'Anjanath Fang')]}],
    weaponTypes: [greatSword, bow],
    ...overrides,
});

const matchMedia = (matches: boolean) => vi.spyOn(window, 'matchMedia').mockImplementation((query: string) => ({
    matches,
    media: query,
    onchange: null,
    addEventListener: vi.fn(),
    removeEventListener: vi.fn(),
    addListener: vi.fn(),
    removeListener: vi.fn(),
    dispatchEvent: vi.fn(),
}) as unknown as MediaQueryList);

let warnings: string[] = [];
let visit: MockInstance<typeof router.visit>;
let put: MockInstance<typeof router.put>;
let post: MockInstance<typeof router.post>;

beforeEach(() => {
    visit = vi.spyOn(router, 'visit').mockImplementation(() => undefined);
    put = vi.spyOn(router, 'put').mockImplementation(() => undefined);
    post = vi.spyOn(router, 'post').mockImplementation(() => undefined);
    localStorage.clear();
    sessionStorage.clear();
    document.body.innerHTML = '';
    warnings = [];
    vi.spyOn(console, 'warn').mockImplementation((message: string) => {
        warnings.push(message);
    });
    vi.spyOn(console, 'error').mockImplementation((message: string) => {
        warnings.push(message);
    });
});

afterEach(() => {
    vi.restoreAllMocks();
});

const mountShow = async (overrides: Record<string, unknown> = {}, hunter: Record<string, unknown> = {}) => {
    const wrapper = mountComponent(Show, props(overrides, hunter));
    await flushPromises();

    return wrapper;
};

describe('Hunter/Show.vue', () => {
    it('mounts and warns about nothing', async () => {
        matchMedia(true);
        const wrapper = await mountShow();

        expect(wrapper.text()).toContain('Aloy');
        expect(wrapper.text()).toContain('Meowscular');
        expect(warnings).toEqual([]);
    });

    describe('the weapon in hand', () => {
        it('is the one equipped within the carried type', async () => {
            const wrapper = await mountShow({}, {
                equipped_weapons: [{id: 20, type_id: 2, name: 'Hunter\'s Bow'}, {id: 11, type_id: 1, name: 'Anja Buster'}],
            });

            expect(wrapper.text()).toContain('Anja Buster');
        });

        it('falls back to the starting weapon of that type', async () => {
            const wrapper = await mountShow();

            expect(wrapper.text()).toContain('Buster Sword');
        });

        it('falls back to the type itself when its weapons were not sent', async () => {
            const wrapper = await mountShow({weaponTypes: []});

            expect(wrapper.text()).toContain('Great Sword');
            expect(wrapper.text()).not.toContain('Buster Sword');
        });

        it('says nothing about a weapon when the hunter carries no type', async () => {
            const wrapper = await mountShow({}, {weapon_type: null, weapon_type_id: null});

            expect(wrapper.text()).not.toContain('Carrying');
        });
    });

    it('lets only somebody who can edit the hunter add parts', async () => {
        const editable = await mountShow();
        const buttons = editable.findAllComponents(AddItemToHunterButton);

        expect(buttons).toHaveLength(2);
        expect(buttons.map((button) => button.props('grouped'))).toEqual([false, true]);
        expect(editable.findAllComponents(GridItemHunter).every((grid) => grid.props('canEdit'))).toBe(true);

        const readOnly = await mountShow({canEdit: false});

        expect(readOnly.findAllComponents(AddItemToHunterButton)).toHaveLength(0);
        expect(readOnly.findAllComponents(GridItemHunter).some((grid) => grid.props('canEdit'))).toBe(false);
    });

    it('lists the parts the hunter holds by name', async () => {
        const wrapper = await mountShow();
        const [, other, monster] = wrapper.findAllComponents(GridItemHunter);

        expect((other.props('items') as Array<{name: string}>).map((entry) => entry.name)).toEqual(['Alpha', 'Zeta']);
        expect((monster.props('items') as Array<{name: string}>).map((entry) => entry.name)).toEqual(['Anjanath Fang', 'Rathalos Scale']);
    });

    it('names only the skills that are running in the header', async () => {
        const wrapper = await mountShow({}, {equipped_armors: [anjaHead, anjaBody]});

        // The set bonus needs the legs too, so it is listed in the panel but
        // not as running.
        const header = wrapper.find('button.sm\\:col-span-2');
        expect(header.text()).toContain('Fire Attack');
        expect(header.text()).not.toContain('Anjanath Will');
        expect(wrapper.findComponent(ActiveSkills).text()).toContain('Anjanath Will');
    });

    it('lays the armour out in rows per monster on a wide screen and per slot on a phone', async () => {
        matchMedia(true);
        const wide = await mountShow({tabOpened: 'armors'});

        expect(wide.findComponent(ArmorBranchGrid).exists()).toBe(true);
        expect(wide.findAllComponents(ListArmorType)).toHaveLength(0);

        vi.restoreAllMocks();
        matchMedia(false);
        const narrow = await mountShow({tabOpened: 'armors'});

        expect(narrow.findComponent(ArmorBranchGrid).exists()).toBe(false);
        expect(narrow.findAllComponents(ListArmorType).map((list) => (list.props('armorSlot') as {key: string}).key)).toEqual(['head', 'body', 'leg']);
    });

    it('keeps the URL in step with the tab without reloading the page', async () => {
        const wrapper = await mountShow();
        expect(visit).not.toHaveBeenCalled();

        const weaponsTab = wrapper.findAll('a').find((link) => link.text() === 'Weapons')!;
        await weaponsTab.trigger('click');
        await flushPromises();

        expect(visit).toHaveBeenCalledTimes(1);
        expect(visit.mock.calls[0][0]).toBe('/campaigns.hunters.show');
        expect(visit.mock.calls[0][1]).toMatchObject({preserveScroll: true, preserveState: true, only: ['tabOpened']});
    });
});

describe('ArmorBranchGrid.vue', () => {
    const grid = (showAllArmors: boolean) => mountComponent(ArmorBranchGrid, {
        canEdit: true,
        showAllArmors,
        campaign: {id: 1},
        hunter: {...baseHunter},
        armorSlots: [
            {key: 'head', label: 'Head', icon: 'span'},
            {key: 'body', label: 'Body', icon: 'span'},
            {key: 'leg', label: 'Leg', icon: 'span'},
        ],
        armors,
        equipped: {head: anjaHead},
        slotById: {},
        equippedIds: [anjaHead.id],
    });

    it('draws only the pieces the hunter owns unless asked for all', () => {
        expect(grid(false).findAllComponents(ArmorCard).map((card) => (card.props('armor') as {id: number}).id)).toEqual([100]);
        expect(grid(true).findAllComponents(ArmorCard).map((card) => (card.props('armor') as {id: number}).id)).toEqual([100, 101, 102, 200]);
    });

    it('drops a monster the hunter has nothing from rather than leaving an empty row', () => {
        expect(grid(false).text()).not.toContain('Rathalos');
        expect(grid(true).text()).toContain('Rathalos');
    });
});

describe('ListWeaponTypes.vue', () => {
    const list = () => mountComponent(ListWeaponTypes, {
        canEdit: true,
        campaign: {id: 1},
        hunter: {
            ...baseHunter,
            weapons: [{id: 11, type_id: 1}, {id: 12, type_id: 1}, {id: 21, type_id: 2}],
            equipped_weapons: [{id: 21, type_id: 2, name: 'Hunter\'s Bow II'}],
        },
        weaponTypes: [greatSword, bow],
    });

    it('counts what was crafted of each type and names the one in hand', () => {
        const cards = list().findAll('.mh-value').map((value) => value.text());
        expect(cards).toEqual(['2', '1']);

        const text = list().text();
        expect(text).toContain('Buster Sword');
        expect(text).toContain('Hunter\'s Bow II');
    });

    it('opens the tree of a type', async () => {
        await list().findAll('button')[1].trigger('click');

        expect(visit).toHaveBeenCalledWith('/campaigns.hunters.weapon-type.index', {preserveScroll: true});
    });
});

describe('CraftArmorModal.vue', () => {
    const modal = (armor: Record<string, unknown>, hunter: Record<string, unknown> = {}) => mountComponent(CraftArmorModal, {
        campaign: {id: 1},
        hunter: {...baseHunter, ...hunter},
        armor,
    });

    it('takes off an equipped piece', async () => {
        const wrapper = modal({...anjaHead, equipped: true});

        expect(wrapper.text()).not.toContain('Craft');
        await wrapper.find('button').trigger('click');

        expect(put).toHaveBeenCalledTimes(1);
        expect(put.mock.calls[0][0]).toBe('/campaigns.hunters.armors.equip');
        expect(put.mock.calls[0][1]).toMatchObject({equip: false});
    });

    it('puts on a piece the hunter owns, and offers no second copy', async () => {
        const wrapper = modal({...anjaHead, equipped: false});

        expect(wrapper.findAll('button')).toHaveLength(1);
        await wrapper.find('button').trigger('click');

        expect(put.mock.calls[0][1]).toMatchObject({equip: true});
    });

    it('shows what a piece costs against what the hunter holds and refuses when short', async () => {
        const wrapper = modal({
            ...anjaLeg,
            can_craft: false,
            items: [
                {id: 1, name: 'Monster Bone', pivot: {number: 2}},
                {id: 5, name: 'Anjanath Fang', pivot: {number: 1}},
            ],
        });

        await wrapper.find('button').trigger('click');
        await flushPromises();

        const rows = [...document.querySelectorAll('tbody tr')].map((row) => [...row.querySelectorAll('td')].map((cell) => cell.textContent?.trim()));
        expect(rows).toEqual([['Monster Bone', '2', '3'], ['Anjanath Fang', '1', '0']]);
        expect(document.querySelectorAll('tbody td.text-red-500')).toHaveLength(1);

        const craft = [...document.querySelectorAll<HTMLButtonElement>('button')].filter((button) => button.textContent?.trim() === 'Craft').at(-1)!;
        expect(craft.disabled).toBe(true);
    });

    it('crafts a piece the hunter can afford', async () => {
        const wrapper = modal({...anjaLeg, can_craft: true, items: []});

        await wrapper.find('button').trigger('click');
        await flushPromises();
        document.querySelector<HTMLButtonElement>('#craft-weapon-btn')!.click();
        await flushPromises();

        expect(post).toHaveBeenCalledTimes(1);
        expect(post.mock.calls[0][0]).toBe('/campaigns.hunters.armors.craft');
        expect(post.mock.calls[0][2]).toMatchObject({errorBag: 'craftArmorHunter'});
    });
});
