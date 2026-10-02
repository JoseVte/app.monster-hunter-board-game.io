// The props `CampaignController::create()` and `edit()` send, key for key,
// shared by `campaignForms.test.ts` (which mounts both pages in a DOM) and
// `ssr.test.ts` (which renders them on the server), so the two suites cannot
// drift into testing different data.
export const expansions = [
    {key: 'ANCIENT_FOREST', label: 'Ancient Forest', base_game: true, extra_days: 0},
    {key: 'PICKING_BONES', label: 'Picking Bones Expansion', base_game: false, extra_days: 15},
];

// What `CampaignController::create()` and `edit()` actually send, key for key.
export const createProps = {
    teams: {1: 'Test Team'},
    expansions,
    baseMaxDays: 25,
    defaultExpansions: ['ANCIENT_FOREST'],
};

export const editProps = {
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
