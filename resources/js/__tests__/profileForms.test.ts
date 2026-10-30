import {afterEach, beforeEach, describe, expect, it, vi} from 'vitest';
import type {MockInstance} from 'vitest';
import {flushPromises} from '@vue/test-utils';
import {router, usePage} from '@inertiajs/vue3';
import {mountComponent, sharedPageProps} from './setup';
import ConnectedAccountsForm from '@/Pages/Profile/Partials/ConnectedAccountsForm.vue';
import InvitationsForm from '@/Pages/Profile/Partials/InvitationsForm.vue';
import ListCampaigns from '@/Pages/Campaign/Partials/ListCampaigns.vue';

// Two profile sections whose rules decide whether somebody can lock
// themselves out (the social accounts) or invite more people than they are
// allowed (the invitations), and the dashboard's campaign list.

let calls: {
    post: MockInstance<typeof router.post>,
    put: MockInstance<typeof router.put>,
    delete: MockInstance<typeof router.delete>,
};

beforeEach(() => {
    calls = {
        post: vi.spyOn(router, 'post').mockImplementation(() => undefined),
        put: vi.spyOn(router, 'put').mockImplementation(() => undefined),
        delete: vi.spyOn(router, 'delete').mockImplementation(() => undefined),
    };
});

afterEach(() => {
    usePage().props.socialLogin = sharedPageProps.socialLogin;
    vi.restoreAllMocks();
});

const buttonsLabelled = (wrapper: ReturnType<typeof mountComponent>, label: string) => wrapper.findAll('button')
    .filter((button) => button.text() === label);

describe('ConnectedAccountsForm.vue', () => {
    const mountWith = async (socialLogin: {providers: Array<'google' | 'github' | 'discord'>, linked: string[], hasPassword: boolean}) => {
        usePage().props.socialLogin = socialLogin;
        const wrapper = mountComponent(ConnectedAccountsForm);
        await flushPromises();

        return wrapper;
    };

    it('offers to connect every provider not linked yet', async () => {
        const wrapper = await mountWith({providers: ['google', 'github', 'discord'], linked: ['github'], hasPassword: true});

        expect(wrapper.findAll('a').map((link) => link.text())).toEqual(['Connect', 'Connect']);
        expect(buttonsLabelled(wrapper, 'Remove')).toHaveLength(1);
        expect(wrapper.text()).toContain('GitHub');
    });

    it('will not unlink the only way left to sign in', async () => {
        const wrapper = await mountWith({providers: ['google', 'github'], linked: ['google'], hasPassword: false});

        expect(buttonsLabelled(wrapper, 'Remove')).toHaveLength(0);
        // Linked, so it is not offered as a connection either.
        expect(wrapper.findAll('a')).toHaveLength(1);
    });

    it('unlinks the last provider once the account has a password', async () => {
        const wrapper = await mountWith({providers: ['google'], linked: ['google'], hasPassword: true});

        await buttonsLabelled(wrapper, 'Remove')[0].trigger('click');

        expect(calls.delete).toHaveBeenCalledTimes(1);
        expect(calls.delete.mock.calls[0][0]).toBe('/profile.social.unlink');
    });

    it('lets either of two linked providers go without a password', async () => {
        const wrapper = await mountWith({providers: ['google', 'discord'], linked: ['google', 'discord'], hasPassword: false});

        expect(buttonsLabelled(wrapper, 'Remove')).toHaveLength(2);
    });

    it('renders nothing to act on when no provider is configured', async () => {
        usePage().props.socialLogin = undefined as never;
        const wrapper = mountComponent(ConnectedAccountsForm);
        await flushPromises();

        expect(wrapper.findAll('button')).toHaveLength(0);
        expect(wrapper.findAll('a')).toHaveLength(0);
    });
});

describe('InvitationsForm.vue', () => {
    const invitation = (id: number, status: string, email: string | null = `guest${id}@example.com`) => ({id, status, email});

    it('counts down only the pending invitations against the limit', () => {
        const wrapper = mountComponent(InvitationsForm, {
            invitationLimit: 3,
            invitations: [invitation(1, 'pending'), invitation(2, 'accepted'), invitation(3, 'revoked'), invitation(4, 'expired')],
        });

        expect(wrapper.text()).toContain('Invitations left: 2');
    });

    it('stops at zero and refuses to send once the limit is used up', () => {
        const wrapper = mountComponent(InvitationsForm, {
            invitationLimit: 1,
            invitations: [invitation(1, 'pending'), invitation(2, 'pending')],
        });

        expect(wrapper.text()).toContain('Invitations left: 0');
        expect(buttonsLabelled(wrapper, 'Invite')[0].attributes('disabled')).toBeDefined();
    });

    it('sends an invitation with the address typed in', async () => {
        const wrapper = mountComponent(InvitationsForm, {invitationLimit: 5, invitations: []});

        await wrapper.find('#invitation_email').setValue('friend@example.com');
        await wrapper.find('form').trigger('submit');

        expect(calls.post).toHaveBeenCalledTimes(1);
        expect(calls.post.mock.calls[0][0]).toBe('/invitations.store');
        expect(calls.post.mock.calls[0][1]).toEqual({email: 'friend@example.com'});
    });

    it('resends and revokes a pending invitation, but cannot resend a shareable link', async () => {
        const wrapper = mountComponent(InvitationsForm, {
            invitationLimit: 5,
            invitations: [invitation(1, 'pending', null), invitation(2, 'pending'), invitation(3, 'accepted')],
        });

        expect(wrapper.text()).toContain('Shareable link');
        expect(buttonsLabelled(wrapper, 'Resend')).toHaveLength(1);
        expect(buttonsLabelled(wrapper, 'Revoke')).toHaveLength(2);

        await buttonsLabelled(wrapper, 'Resend')[0].trigger('click');
        expect(calls.put.mock.calls[0][0]).toBe('/invitations.resend');

        await buttonsLabelled(wrapper, 'Revoke')[0].trigger('click');
        expect(calls.delete.mock.calls[0][0]).toBe('/invitations.destroy');
    });
});

describe('ListCampaigns.vue', () => {
    const campaign = (id: number, name: string, description: string | null) => ({
        id,
        name,
        description_parsed: description,
        health_potions: 2,
        max_days: 30,
        days_count: 4,
        team: {name: 'Crew', owner: {name: 'Owner'}},
        users: [],
    });

    it('cuts a description past twenty characters and leaves a short one alone', () => {
        const long = 'x'.repeat(300);
        const wrapper = mountComponent(ListCampaigns, {
            campaigns: [campaign(1, 'Long', long), campaign(2, 'Short', 'Brief'), campaign(3, 'Empty', null)],
        });
        const text = wrapper.text();

        expect(text).not.toContain(long);
        expect(text).toContain(`${'x'.repeat(20)}...`);
        expect(text).not.toContain('x'.repeat(21));
        expect(text).toContain('Brief');
        expect(text).not.toContain('null');
    });

    it('shows the potions against the three a party holds and the days against the limit', () => {
        const text = mountComponent(ListCampaigns, {campaigns: [campaign(1, 'Crew', 'Brief')]}).text();

        expect(text).toContain('2 / 3');
        expect(text).toContain('4 / 30');
    });
});
