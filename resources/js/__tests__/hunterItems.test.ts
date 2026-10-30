import {afterEach, beforeEach, describe, expect, it, vi} from 'vitest';
import type {MockInstance} from 'vitest';
import {flushPromises} from '@vue/test-utils';
import {router} from '@inertiajs/vue3';
import VueMultiselect from 'vue-multiselect';
import {mountComponent} from './setup';
import AddItemToHunterButton from '@/Pages/Hunter/Partials/AddItemToHunterButton.vue';
import GridItemHunter from '@/Pages/Hunter/Partials/GridItemHunter.vue';
import UpdateCountItemForm from '@/Pages/Hunter/Partials/UpdateCountItemForm.vue';
import CountForm from '@/Components/Form/CountForm.vue';

// The parts a hunter carries: the grid of counters on the items tab, and the
// modal that logs a hunt's haul in one request. Both write through
// `router.put`, which is stubbed so the payload can be read back instead of
// going to a server that is not there.

const campaign = {id: 1, name: 'Crew'};

const item = (id: number, name: string) => ({id, name});
const held = (id: number, number: number) => ({id, name: `item ${id}`, pivot: {item_id: id, hunter_id: 7, number}});

const bone = item(1, 'Monster Bone');
const ore = item(2, 'Iron Ore');
const hide = item(3, 'Ancient Hide');

const hunter = {id: 7, name: 'Aloy', items: [held(1, 4)]};

let put: MockInstance<typeof router.put>;

beforeEach(() => {
    put = vi.spyOn(router, 'put').mockImplementation(() => undefined);
    document.body.innerHTML = '';
});

afterEach(() => {
    vi.restoreAllMocks();
});

const lastPut = () => put.mock.calls.at(-1) as unknown as [string, Record<string, unknown>, Record<string, unknown>];

describe('UpdateCountItemForm.vue', () => {
    it('sends the count one up and one down', async () => {
        const wrapper = mountComponent(UpdateCountItemForm, {canEdit: true, campaign, hunter, item: bone, countItem: 4});
        const [minus, plus] = wrapper.findAll('button');

        await plus.trigger('click');
        expect(lastPut()[0]).toBe('/campaigns.hunters.items.update-count');
        expect(lastPut()[1]).toMatchObject({count_item: 5});
        expect(lastPut()[2]).toMatchObject({errorBag: 'updateHunterItem', preserveScroll: true});

        await minus.trigger('click');
        expect(lastPut()[1]).toMatchObject({count_item: 4});
    });

    it('only shows the count to somebody who cannot edit the hunter', () => {
        const wrapper = mountComponent(UpdateCountItemForm, {canEdit: false, campaign, hunter, item: bone, countItem: 4});

        expect(wrapper.findComponent(CountForm).exists()).toBe(false);
        expect(wrapper.findAll('button')).toHaveLength(0);
        expect(wrapper.text()).toContain('4');
    });

    it('hides a part the hunter has none of only when asked to', () => {
        const empty = {campaign, hunter, item: ore, countItem: 0, canEdit: true};

        expect(mountComponent(UpdateCountItemForm, {...empty, hideEmpty: true}).text()).toBe('');
        expect(mountComponent(UpdateCountItemForm, {...empty, hideEmpty: false}).text()).toContain('Iron Ore');
        expect(mountComponent(UpdateCountItemForm, {...empty, countItem: 2, hideEmpty: true}).text()).toContain('Iron Ore');
    });

    // A count changed from anywhere else (the "add items" modal, which sets the
    // same pivot) comes back as a new prop, and the next click has to start from
    // it rather than from the count the form was mounted with.
    it('counts on from the latest count after the page reloads', async () => {
        const wrapper = mountComponent(UpdateCountItemForm, {canEdit: true, campaign, hunter, item: bone, countItem: 4});

        await wrapper.setProps({countItem: 10});
        await wrapper.findAll('button')[1].trigger('click');

        expect(lastPut()[1]).toMatchObject({count_item: 11});
    });

    // The server refuses anything under zero (`min:0`), and a form left holding
    // -1 would make the next plus send 0.
    it('never asks for fewer than zero', async () => {
        const wrapper = mountComponent(UpdateCountItemForm, {canEdit: true, campaign, hunter, item: ore, countItem: 0});

        await wrapper.findAll('button')[0].trigger('click');

        expect(put.mock.calls.every(([, data]) => (data as unknown as {count_item: number}).count_item >= 0)).toBe(true);
    });
});

describe('GridItemHunter.vue', () => {
    it('splits the parts into two columns, the longer one first, each with what the hunter holds', () => {
        const wrapper = mountComponent(GridItemHunter, {canEdit: true, campaign, hunter, items: [bone, ore, hide]});

        const columns = [...wrapper.element.children].map((column) => column.querySelectorAll('a').length);
        expect(columns).toEqual([2, 1]);

        const counts = wrapper.findAllComponents(UpdateCountItemForm).map((form) => [(form.props('item') as {id: number}).id, form.props('countItem')]);
        expect(counts).toEqual([[1, 4], [2, 0], [3, 0]]);
    });
});

describe('AddItemToHunterButton.vue', () => {
    const mountButton = async () => {
        const wrapper = mountComponent(AddItemToHunterButton, {
            campaign,
            hunter,
            items: [bone, ore, hide],
            label: 'Add Other Item',
            labelBtn: 'Add Other Item',
        });

        await wrapper.find('button').trigger('click');
        await flushPromises();

        return wrapper;
    };

    const pick = async (wrapper: Awaited<ReturnType<typeof mountButton>>, picked: ReturnType<typeof item>) => {
        const select = wrapper.findComponent(VueMultiselect);
        select.vm.$emit('update:modelValue', picked);
        select.vm.$emit('select', picked);
        await flushPromises();
    };

    const countInput = () => document.querySelector<HTMLInputElement>('#add-item-count')!;
    const button = (text: string) => [...document.querySelectorAll<HTMLButtonElement>('button')]
        .filter((candidate) => candidate.textContent?.trim() === text)
        .at(-1)!;
    const stagedRows = () => [...document.querySelectorAll('li')]
        .map((row) => `${row.querySelector('span')?.textContent} x${row.querySelector('.mh-value')?.textContent}`);

    it('starts the count at what the hunter already holds, since a count replaces', async () => {
        const wrapper = await mountButton();

        await pick(wrapper, bone);
        expect(countInput().value).toBe('4');

        await pick(wrapper, ore);
        expect(countInput().value).toBe('0');
    });

    it('cannot save an empty list', async () => {
        await mountButton();

        expect(button('Add to list').disabled).toBe(true);
        expect(document.querySelector<HTMLButtonElement>('#add-item-btn')!.disabled).toBe(true);
    });

    it('gathers several parts, replaces a repeated one and lets one be taken back out', async () => {
        const wrapper = await mountButton();

        await pick(wrapper, ore);
        countInput().value = '2';
        countInput().dispatchEvent(new Event('input'));
        button('Add to list').click();
        await flushPromises();

        await pick(wrapper, hide);
        countInput().value = '1';
        countInput().dispatchEvent(new Event('input'));
        button('Add to list').click();
        await flushPromises();

        // The same part again is a correction, not a second line.
        await pick(wrapper, ore);
        countInput().value = '5';
        countInput().dispatchEvent(new Event('input'));
        button('Add to list').click();
        await flushPromises();

        expect(stagedRows()).toEqual(['Iron Ore x5', 'Ancient Hide x1']);

        button('Remove').click();
        await flushPromises();
        expect(stagedRows()).toEqual(['Iron Ore x5']);

        document.querySelector<HTMLButtonElement>('#add-item-btn')!.click();
        await flushPromises();

        expect(put).toHaveBeenCalledTimes(1);
        expect(lastPut()[0]).toBe('/campaigns.hunters.items.store-many');
        expect(lastPut()[1]).toMatchObject({items: [{item_id: 2, number: 5}]});
        expect(lastPut()[2]).toMatchObject({errorBag: 'storeHunterItems'});
    });

    it('sends a count that is not a number as zero', async () => {
        const wrapper = await mountButton();

        await pick(wrapper, hide);
        countInput().value = '';
        countInput().dispatchEvent(new Event('input'));
        button('Add to list').click();
        await flushPromises();

        document.querySelector<HTMLButtonElement>('#add-item-btn')!.click();
        await flushPromises();

        expect(lastPut()[1]).toMatchObject({items: [{item_id: 3, number: 0}]});
    });

    it('forgets the list when the modal is closed', async () => {
        const wrapper = await mountButton();

        await pick(wrapper, ore);
        button('Add to list').click();
        await flushPromises();
        expect(stagedRows()).toHaveLength(1);

        button('Cancel').click();
        await flushPromises();
        await wrapper.find('button').trigger('click');
        await flushPromises();

        expect(stagedRows()).toHaveLength(0);
        expect(put).not.toHaveBeenCalled();
    });
});
