import {afterEach, beforeEach, describe, expect, it, vi} from 'vitest';
import {flushPromises} from '@vue/test-utils';
import {router} from '@inertiajs/vue3';
import {mountComponent} from './setup';
import MemberManager from '@/Pages/Campaign/Partials/MemberManager.vue';

// "Remove Hunter" used to store `!!campaignHunter.id` as the hunter being
// removed, so the delete went to `campaigns.hunters.destroy` with `true` in
// place of the hunter and the server never found one to remove.
const props = {
    campaign: {
        id: 7,
        campaign_invitations: [],
        users: [
            {
                id: 2,
                name: 'Other Hunter',
                profile_photo_url: '/images/avatar.png',
                membership: {hunter_id: 42, hunter: {id: 42, name: 'Aiko'}, role: {name: 'player'}},
            },
        ],
    },
    availableRoles: [],
    userPermissions: {
        canAddCampaignMembers: false,
        canRemoveCampaignMembers: true,
        canUpdateCampaign: true,
    },
};

beforeEach(() => {
    vi.spyOn(router, 'delete').mockImplementation(() => undefined);
});

afterEach(() => {
    vi.restoreAllMocks();
});

describe('Campaign/Partials/MemberManager.vue', () => {
    it('removes the hunter by its id', async () => {
        const route = vi.spyOn(globalThis, 'route');
        const wrapper = mountComponent(MemberManager, props);

        const removeHunter = wrapper.findAll('button').find((button) => button.text() === 'Remove Hunter');

        if (! removeHunter) {
            throw new Error('The Remove Hunter button is not on the page.');
        }

        await removeHunter.trigger('click');
        await flushPromises();

        const confirm = [...document.body.querySelectorAll('button')]
            .filter((button) => button.textContent?.trim() === 'Remove')
            .at(-1);

        if (! confirm) {
            throw new Error('The removal is not asking for confirmation.');
        }

        confirm.click();
        await flushPromises();

        expect(route).toHaveBeenCalledWith('campaigns.hunters.destroy', [props.campaign, 42]);
        expect(router.delete).toHaveBeenCalled();

        wrapper.unmount();
    });
});
