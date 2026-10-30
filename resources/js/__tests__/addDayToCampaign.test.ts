import {afterEach, beforeEach, describe, expect, it, vi} from 'vitest';
import type {MockInstance} from 'vitest';
import {flushPromises} from '@vue/test-utils';
import {router} from '@inertiajs/vue3';
import VueMultiselect from 'vue-multiselect';
import {mountComponent} from './setup';
import AddDayToCampaignButton from '@/Pages/Campaign/Partials/AddDayToCampaignButton.vue';

// What the add-day form puts on the wire. The pickers hold whole objects
// (an activity, a monster, a `{key, label}` option) and the request wants ids
// and enum keys, so the form translates before sending; this pins that
// translation against what `AddOrUpdateCampaignDayRequest` reads.

const downtime = {key: 'DOWNTIME', label: 'Downtime'};
const monsterDay = {key: 'MONSTER', label: 'Hunt'};
const hard = {key: 'HARD', label: 'Hard'};

const forage = {id: 1, name: 'Forage'};
const train = {id: 2, name: 'Train'};

// User 1 owns the campaign and has no hunter; user 2 plays hunter 9. The two
// ids differ on purpose, which is exactly the case a real campaign is in.
const campaign = {
    id: 3,
    users: [
        {id: 1, name: 'Owner', membership: {hunter_id: null, hunter: null}},
        {id: 2, name: 'Player', membership: {hunter_id: 9, hunter: {id: 9, name: 'Aloy'}}},
    ],
};

let put: MockInstance<typeof router.put>;

beforeEach(() => {
    put = vi.spyOn(router, 'put').mockImplementation(() => undefined);
    document.body.innerHTML = '';
});

afterEach(() => {
    vi.restoreAllMocks();
});

const openForm = async () => {
    const wrapper = mountComponent(AddDayToCampaignButton, {
        campaign,
        days: [forage, train],
        monsters: [{id: 5, name: 'Rathalos'}],
        maxActivities: 3,
    });

    await wrapper.find('button').trigger('click');
    await flushPromises();

    return wrapper;
};

const choose = async (wrapper: Awaited<ReturnType<typeof openForm>>, id: string, value: unknown) => {
    const picker = wrapper.findAllComponents(VueMultiselect).find((candidate) => candidate.attributes('id') === id
        || candidate.props('id') === id)!;
    picker.vm.$emit('update:modelValue', value);
    await flushPromises();
};

const submit = async () => {
    document.querySelector<HTMLButtonElement>('#delete-user-btn')!.click();
    await flushPromises();

    return put.mock.calls.at(-1)![1] as unknown as Record<string, unknown>;
};

describe('AddDayToCampaignButton.vue', () => {
    it('sends a hunt as the monster id and the difficulty key', async () => {
        const wrapper = await openForm();

        await choose(wrapper, 'type-day', monsterDay);
        await choose(wrapper, 'add-monster-id', {id: 5, name: 'Rathalos'});
        await choose(wrapper, 'difficulty', hard);

        const sent = await submit();

        expect(put.mock.calls[0][0]).toBe('/campaigns.add-day');
        expect(sent).toMatchObject({type_day: 'MONSTER', monster_id: 5, difficulty: 'HARD', hunted: false});
    });

    it('sends a whole-party downtime day as a list of activity ids', async () => {
        const wrapper = await openForm();

        await choose(wrapper, 'type-day', downtime);
        await choose(wrapper, 'add-day-id', [forage, train]);

        const sent = await submit();

        expect(sent).toMatchObject({type_day: 'DOWNTIME', all_hunters_same_activity: true, day_id: [1, 2], monster_id: null, difficulty: null});
    });

    it('sends nothing as the type when none was picked, for the server to refuse', async () => {
        await openForm();

        expect(await submit()).toMatchObject({type_day: null});
    });

    // `CampaignController::fillDowntimeDay` attaches each key of `hunter_day_id`
    // as a hunter id, so the pickers are keyed by the hunter, not by the user
    // playing it. `UpdateCampaignDayModal.vue` builds the same map.
    it('keys each hunter\'s activities by the hunter, as the server reads them', async () => {
        const wrapper = await openForm();

        await choose(wrapper, 'type-day', downtime);
        (document.querySelector<HTMLInputElement>('#all-hunters')!).click();
        await flushPromises();
        await choose(wrapper, 'add-day-id-2', [train]);

        const sent = await submit();

        expect(sent.hunter_day_id).toEqual({9: [2]});
    });
});
