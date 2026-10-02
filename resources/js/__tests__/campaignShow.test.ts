import {afterEach, beforeEach, describe, expect, it, vi} from 'vitest';
import {flushPromises} from '@vue/test-utils';
import {router} from '@inertiajs/vue3';
import {mountComponent} from './setup';
import Show from '@/Pages/Campaign/Show.vue';
import AddDayToCampaignButton from '@/Pages/Campaign/Partials/AddDayToCampaignButton.vue';
import CampaignDay from '@/Pages/Campaign/Partials/CampaignDay.vue';
import UpdateCampaignDayModal from '@/Pages/Campaign/Partials/UpdateCampaignDayModal.vue';
import Calendar from '@/Components/Icons/Calendar.vue';

// The campaign page, mounted whole. `maxDowntimeActivities` travels from
// `CampaignController::show()` through this page to two places, the add-day
// button directly and the edit modal by way of each `CampaignDay`, and a page
// that receives a prop and forgets to pass it on is exactly the bug that broke
// the create form (`campaignForms.test.ts`). Nothing mounted this page before,
// so nothing would have noticed the same thing happening here; the server
// still caps the activities, but the form would have let a hunter pick the
// whole list first.

const activity = (id: number, name: string) => ({id, name, description: `${name} description`});

const forage = activity(1, 'Forage');
const train = activity(2, 'Train');
const rest = activity(3, 'Rest');

const hunter = {id: 7, name: 'Aloy', campaign_id: 1, weapon_type: {id: 1, name: 'Great Sword'}, palico: null};

// A day holds one pivot row per hunter per activity, so a hunter who did three
// things that day comes back three times, each with its own pivot. That is the
// shape `days.hunters.pivot.downtimeActivity` actually produces.
const pivotRow = (picked: ReturnType<typeof activity>) => ({
    ...hunter,
    pivot: {day_id: 1, hunter_id: hunter.id, downtime_activity_id: picked.id, downtime_activity: picked},
});

const campaign = {
    id: 1,
    team_id: 1,
    name: 'Iceborne Crew',
    description: 'Something',
    description_parsed: 'Something',
    description_parsed_html: '<p>Something</p>',
    max_days: 40,
    max_days_automatic: true,
    health_potions: 1,
    expansions: ['ANCIENT_FOREST'],
    days_count: 1,
    created_at: null,
    updated_at: null,
    team: {id: 1, name: 'Test Team', user_id: 1, personal_team: true, owner: {id: 1, name: 'Test Hunter'}, users: [], team_invitations: []},
    campaign_invitations: [],
    days: [
        {
            id: 1,
            number: 1,
            campaign_id: 1,
            monster_id: null,
            monster: null,
            downtime_activity_id: null,
            downtime_activity: null,
            all_hunters_same_activity: false,
            difficulty: null,
            hunted: false,
            hunters: [pivotRow(forage), pivotRow(train), pivotRow(rest)],
        },
    ],
    users: [
        {
            id: 1,
            name: 'Test Hunter',
            email: 'test@example.com',
            profile_photo_url: '/images/avatar.png',
            membership: {role_id: 1, hunter_id: hunter.id, role: {id: 1, name: 'admin-campaign'}, hunter},
        },
    ],
};

const props = {
    campaign,
    downtimeDays: [forage, train, rest],
    monsters: [],
    maxDowntimeActivities: 3,
    availableRoles: [{key: 'admin-campaign', name: 'Administrator', description: 'Can do anything.'}],
    permissions: {
        canAddCampaignMembers: true,
        canDeleteCampaign: true,
        canRemoveCampaignMembers: true,
        canUpdateCampaign: true,
        canUpdateCampaignMembers: true,
    },
};

let warnings: string[] = [];

beforeEach(() => {
    vi.spyOn(router, 'put').mockImplementation(() => undefined);
    // `Show.vue` remembers whether the calendar was open. In the app that is
    // session storage, as `app.ts` configures `vue3-storage`; here the plugin
    // is not installed and its default is local storage. Both are cleared so
    // the choice never carries from one test into the next.
    localStorage.clear();
    sessionStorage.clear();
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

// The calendar is closed until somebody opens it (the choice is kept in
// session storage), and the days only render inside it. The toggle is a
// clickable `<div>` around the calendar icon rather than a button, so it is
// found by that icon: the first one on the page, ahead of any a downtime day
// draws, since those only exist once it is open.
async function mountWithCalendar() {
    const wrapper = mountComponent(Show, props);

    await flushPromises();

    if (wrapper.findAllComponents(CampaignDay).length === 0) {
        (wrapper.findComponent(Calendar).element.parentElement as HTMLElement).click();
        await flushPromises();
    }

    return wrapper;
}

describe('Campaign/Show.vue', () => {
    it('mounts and warns about nothing', async () => {
        const wrapper = mountComponent(Show, props);

        await flushPromises();

        expect(wrapper.html()).not.toBe('');
        expect(warnings).toEqual([]);
    });

    it('hands the add-day button the cap the controller sent', async () => {
        const wrapper = mountComponent(Show, props);

        await flushPromises();

        expect(wrapper.findComponent(AddDayToCampaignButton).props('maxActivities')).toBe(3);
    });

    it('hands every day\'s edit modal the same cap', async () => {
        const wrapper = await mountWithCalendar();

        const modals = wrapper.findAllComponents(UpdateCampaignDayModal);

        expect(modals.length).toBeGreaterThan(0);
        expect(modals.map((modal) => modal.props('maxActivities'))).toEqual(modals.map(() => 3));
    });

    it('lists a hunter once with every activity they did that day', async () => {
        const wrapper = await mountWithCalendar();

        const day = wrapper.findComponent(CampaignDay);
        const text = day.text();

        // Three pivot rows for one hunter: the name once, all three activities.
        expect(text.split('Aloy').length - 1).toBe(1);
        expect(text).toContain('Forage');
        expect(text).toContain('Train');
        expect(text).toContain('Rest');
    });
});
