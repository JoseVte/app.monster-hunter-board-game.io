import {describe, expect, it} from 'vitest';
import {mountComponent} from './setup';
import CampaignTimerFields from '@/Pages/Campaign/Partials/CampaignTimerFields.vue';

// The timer is worked out in two places that have to agree: here, live, as the
// number the form shows, and in `Campaign::booted()` on the way into the
// database. `CampaignTimerTest` covers the server's half. This covers the
// switch between automatic and manual, which exists only on the client.
const expansions = [
    {key: 'ANCIENT_FOREST', label: 'Ancient Forest', base_game: true, extra_days: 0},
    {key: 'WILDSPIRE_WASTE', label: 'Wildspire Waste', base_game: true, extra_days: 0},
    {key: 'PICKING_BONES', label: 'Picking Bones Expansion', base_game: false, extra_days: 15},
];

const BASE = 25;

function mountFields(overrides: Record<string, unknown> = {}) {
    return mountComponent(CampaignTimerFields, {
        expansions,
        baseMaxDays: BASE,
        errors: {},
        selected: [],
        automatic: true,
        maxDays: BASE,
        ...overrides,
    });
}

// `defineModel` emits rather than mutating, so the last `update:maxDays` is
// what a parent form's `form.max_days` would be holding.
function lastMaxDays(wrapper: ReturnType<typeof mountFields>) {
    const emitted = wrapper.emitted('update:maxDays');

    return emitted ? emitted.at(-1)?.[0] : undefined;
}

describe('CampaignTimerFields', () => {
    it('keeps the two base games apart from what is added to them', () => {
        // Anchored on the boxes themselves rather than on every `<label>`:
        // the section headings are labels too, and so is the switch, which
        // carries a checkbox of its own with no `value`.
        const boxes = mountFields()
            .findAll('input[type="checkbox"][value]')
            .map((box) => box.element.closest('label')?.textContent?.replace(/\s+/g, ' ').trim());

        // The two base games first, in the enum's order, then the add-ons: a
        // reader has to answer "which box am I playing" before "what have I
        // bolted onto it", and only the first of those two is required.
        expect(boxes).toEqual([
            'Ancient Forest',
            'Wildspire Waste',
            'Picking Bones Expansion (+15 days)',
        ]);
    });

    it('offers every expansion with what it adds to the timer', () => {
        const labels = mountFields().text();

        expect(labels).toContain('Picking Bones Expansion');
        expect(labels).toContain('+15');
        // Nothing to add, so no parenthetical at all rather than "(+0 days)".
        expect(labels).not.toContain('+0');
    });

    it('suggests the base timer when no expansion is in play', () => {
        expect(mountFields().text()).toContain(`Suggested: ${BASE} days`);
    });

    it('adds an expansion own days to the suggestion', () => {
        const wrapper = mountFields({selected: ['PICKING_BONES']});

        expect(wrapper.text()).toContain('Suggested: 40 days');
    });

    it('writes the suggestion back on automatic', () => {
        const wrapper = mountFields({selected: ['PICKING_BONES'], maxDays: 1});

        expect(lastMaxDays(wrapper)).toBe(40);
    });

    it('leaves a hand typed timer alone on manual', () => {
        const wrapper = mountFields({selected: ['PICKING_BONES'], automatic: false, maxDays: 7});

        expect(lastMaxDays(wrapper)).toBeUndefined();
        expect((wrapper.find('#max_days').element as HTMLInputElement).value).toBe('7');
    });

    it('still suggests a timer on manual', () => {
        const wrapper = mountFields({selected: ['PICKING_BONES'], automatic: false, maxDays: 7});

        expect(wrapper.text()).toContain('Suggested: 40 days');
    });

    it('locks the field on automatic and releases it on manual', () => {
        expect(mountFields().find('#max_days').attributes('disabled')).toBeDefined();
        expect(mountFields({automatic: false}).find('#max_days').attributes('disabled')).toBeUndefined();
    });

    it('follows the expansions as they are ticked', async () => {
        const wrapper = mountFields();

        await wrapper.setProps({selected: ['PICKING_BONES']});

        expect(lastMaxDays(wrapper)).toBe(40);
    });
});
