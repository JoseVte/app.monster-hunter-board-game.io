import {afterEach, beforeEach, describe, expect, it} from 'vitest';
import {i18n, mountComponent} from './setup';
import CampaignRules from '@/Pages/Campaign/Partials/CampaignRules.vue';

// The rules are the one piece of text in the app that a component reads out of
// the translation catalog as a *list* rather than as a string, through
// vue-i18n's `tm()`. Nothing else in the suite exercises that, and it is the
// part most likely to break quietly: `tm()` answers `{}` for a path it cannot
// find, so a renamed key or a lang file that stops being mirrored into
// `vue-i18n-locales.generated.js` shows an empty panel rather than an error.
const messages = {
    'campaign-rules': {
        downtime: ['One day at a time.', 'Three activities each.'],
        expansions: {
            PICKING_BONES: ['Fifteen more days.'],
        },
    },
};

// The names come from `App\Enum\MonsterExpansion` through the page's props, in
// the enum's own order, and include expansions the lang file says nothing
// about yet.
const expansions = [
    {key: 'ANCIENT_FOREST', label: 'Ancient Forest'},
    {key: 'PICKING_BONES', label: 'Picking Bones Expansion'},
];

// Everything ticked on the form above, so the only thing keeping an expansion
// off the panel in these cases is whether it has rules.
const selected = expansions.map((expansion) => expansion.key);

const props = {expansions, selected};

describe('CampaignRules', () => {
    beforeEach(() => {
        i18n.global.setLocaleMessage('en', messages);
    });

    afterEach(() => {
        i18n.global.setLocaleMessage('en', {});
    });

    it('prints every downtime rule as its own bullet', () => {
        const wrapper = mountComponent(CampaignRules, props);

        const bullets = wrapper.findAll('li').map((li) => li.text());

        expect(bullets).toContain('One day at a time.');
        expect(bullets).toContain('Three activities each.');
    });

    it('shows an expansion only once it has rules', () => {
        const wrapper = mountComponent(CampaignRules, props);

        const headings = wrapper.findAll('summary').map((summary) => summary.text());

        expect(headings).toContain('Picking Bones Expansion');
        expect(headings).not.toContain('Ancient Forest');
    });

    it('starts collapsed', () => {
        const wrapper = mountComponent(CampaignRules, props);

        expect(wrapper.findAll('details').every((details) => ! details.attributes('open'))).toBe(true);
    });

    it('leaves out an expansion that is not in play', () => {
        const wrapper = mountComponent(CampaignRules, {expansions, selected: []});

        expect(wrapper.findAll('summary').map((summary) => summary.text()))
            .not.toContain('Picking Bones Expansion');
        // The downtime rules are not an expansion's, so they stay.
        expect(wrapper.findAll('li').map((li) => li.text())).toContain('One day at a time.');
    });

    it('renders nothing at all when the catalog is empty', () => {
        i18n.global.setLocaleMessage('en', {});

        const wrapper = mountComponent(CampaignRules, props);

        expect(wrapper.find('details').exists()).toBe(false);
        expect(wrapper.find('h3').exists()).toBe(false);
    });
});
