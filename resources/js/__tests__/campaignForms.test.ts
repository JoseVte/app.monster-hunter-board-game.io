import {afterEach, beforeEach, describe, expect, it, vi} from 'vitest';
import {flushPromises} from '@vue/test-utils';
import {router} from '@inertiajs/vue3';
import {mountComponent} from './setup';
import Create from '@/Pages/Campaign/Create.vue';
import Edit from '@/Pages/Campaign/Edit.vue';

// The two campaign pages, mounted whole rather than through their form
// partials, because the bug this exists for lived in the page and not in the
// form: `Create.vue` received `baseMaxDays` from the controller and never
// declared or forwarded it, so `CampaignTimerFields` added `undefined` to the
// expansions' days and printed "Suggested: NaN days" on every create. Both
// forms were already covered; neither page was, and that gap is exactly the
// shape of the gap.
//
// Vue does warn about the missing required prop, which is why the warnings
// assertion below is the general guard and the NaN one is the specific one.
const expansions = [
    {key: 'ANCIENT_FOREST', label: 'Ancient Forest', base_game: true, extra_days: 0},
    {key: 'PICKING_BONES', label: 'Picking Bones Expansion', base_game: false, extra_days: 15},
];

// What `CampaignController::create()` and `edit()` actually send, key for key.
const createProps = {
    teams: {1: 'Test Team'},
    expansions,
    baseMaxDays: 25,
    defaultExpansions: ['ANCIENT_FOREST'],
};

const editProps = {
    campaign: {
        id: 1,
        team_id: 1,
        name: 'A campaign',
        description: 'Something',
        max_days: 40,
        max_days_automatic: true,
        health_potions: 0,
        // Null rather than `[]`, the way a campaign stored before the column
        // existed reads, since that is the case the edit form guards with `??`.
        expansions: null,
        created_at: null,
        updated_at: null,
        team: {id: 1, name: 'Test Team', user_id: 1, personal_team: true, owner: {id: 1, name: 'Owner'}},
    },
    expansions,
    baseMaxDays: 25,
};

// `AppLayout` wraps both pages and carries a logout `<form>` of its own, which
// is the first one in the document; submitting that instead fires a real
// Inertia request at `/logout`. The campaign form is the one holding the timer
// field.
function campaignForm(wrapper: ReturnType<typeof mountComponent>) {
    const form = wrapper.findAll('form').find((candidate) => candidate.find('#max_days').exists());

    if (! form) {
        throw new Error('The campaign form is not on the page.');
    }

    return form;
}

let warnings: string[] = [];

// `useForm().post(...)` ends up at `router[method](url, data, options)`, which
// in happy-dom fires a real XHR at a server that is not there. Stubbing the
// two the forms use keeps the request out and, more usefully, turns "did it
// submit" into something the tests can assert either way.
beforeEach(() => {
    vi.spyOn(router, 'post').mockImplementation(() => undefined);
    vi.spyOn(router, 'put').mockImplementation(() => undefined);
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

describe.each([
    ['Campaign/Create.vue', Create, createProps],
    ['Campaign/Edit.vue', Edit, editProps],
])('%s', (_name, component, props) => {
    it('mounts and warns about nothing', async () => {
        const wrapper = mountComponent(component, props);

        await flushPromises();

        expect(wrapper.html()).not.toBe('');
        expect(warnings).toEqual([]);
    });

    it('works a real timer out rather than printing NaN', async () => {
        const wrapper = mountComponent(component, props);

        await flushPromises();

        expect(wrapper.text()).toContain('Suggested: 25 days');
        expect(wrapper.text()).not.toContain('NaN');
    });

    it('hands the timer field the suggestion it is showing', async () => {
        const wrapper = mountComponent(component, props);

        await flushPromises();

        const field = wrapper.find('#max_days').element as HTMLInputElement;

        expect(field.value).toBe('25');
        expect(field.disabled).toBe(true);
    });
});

describe('Campaign/Create.vue', () => {
    it('starts with the default box ticked', async () => {
        const wrapper = mountComponent(Create, createProps);

        await flushPromises();

        const ticked = wrapper
            .findAll('input[type="checkbox"][value]')
            .filter((box) => (box.element as HTMLInputElement).checked)
            .map((box) => box.attributes('value'));

        expect(ticked).toEqual(['ANCIENT_FOREST']);
    });

    it('says a base game is needed rather than submitting without one', async () => {
        const wrapper = mountComponent(Create, {...createProps, defaultExpansions: []});

        await flushPromises();
        await campaignForm(wrapper).trigger('submit');
        await flushPromises();

        expect(wrapper.text()).toContain('Pick at least one of the base games.');
        expect(router.post).not.toHaveBeenCalled();
    });

    it('submits once a base game is ticked, and stops saying it', async () => {
        const wrapper = mountComponent(Create, {...createProps, defaultExpansions: []});

        await flushPromises();
        await campaignForm(wrapper).trigger('submit');
        await flushPromises();

        await wrapper.find('input[type="checkbox"][value="ANCIENT_FOREST"]').setValue(true);
        await campaignForm(wrapper).trigger('submit');
        await flushPromises();

        expect(wrapper.text()).not.toContain('Pick at least one of the base games.');
        expect(router.post).toHaveBeenCalledTimes(1);
    });
});

describe('Campaign/Edit.vue', () => {
    it('says a base game is needed on a campaign stored without one', async () => {
        // `expansions` is null on every campaign created before the column
        // existed, so the edit form opens with nothing ticked and the owner
        // has to answer the question before the next save goes through.
        const wrapper = mountComponent(Edit, editProps);

        await flushPromises();
        await campaignForm(wrapper).trigger('submit');
        await flushPromises();

        expect(wrapper.text()).toContain('Pick at least one of the base games.');
        expect(router.put).not.toHaveBeenCalled();
    });
});
