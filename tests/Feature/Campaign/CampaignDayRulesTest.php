<?php

use App\Models\User;
use App\Enum\DayType;
use App\Models\Hunter;
use App\Models\Monster;
use App\Models\Campaign;
use App\Enum\MonsterDifficulty;
use App\Models\DowntimeActivity;
use App\Events\UserMonsterHunted;
use Spatie\Permission\Models\Role;

// The campaign calendar: how a day is numbered, what a hunt or a downtime day
// writes, and what turning one into the other leaves behind.

beforeEach(function (): void {
    $this->actingAs($this->user = User::factory()->withPersonalTeam()->create());
    $this->campaign = Campaign::factory()->create(['team_id' => $this->user->currentTeam->id]);
    $this->monster = Monster::factory()->create();
    $this->activities = DowntimeActivity::factory(3)->create();
});

function hunt(Monster $monster, bool $hunted = false): array
{
    return [
        'type_day' => DayType::MONSTER->name,
        'monster_id' => $monster->id,
        'difficulty' => MonsterDifficulty::NORMAL->name,
        'hunted' => $hunted,
    ];
}

function memberWithHunter(Campaign $campaign): Hunter
{
    $member = User::factory()->create();
    $hunter = Hunter::factory()->create(['campaign_id' => $campaign->id]);
    $campaign->users()->attach($member, [
        'role_id' => Role::findByName('member-campaign', 'sanctum')->id,
        'hunter_id' => $hunter->id,
    ]);

    return $hunter;
}

test('days are numbered one after another whatever kind they are', function (): void {
    Event::fake(UserMonsterHunted::class);

    $this->put(route('campaigns.add-day', $this->campaign), hunt($this->monster));
    $this->put(route('campaigns.add-day', $this->campaign), [
        'type_day' => DayType::DOWNTIME->name,
        'all_hunters_same_activity' => true,
        'day_id' => [$this->activities[0]->id],
    ]);
    $this->put(route('campaigns.add-day', $this->campaign), hunt($this->monster));

    expect($this->campaign->days()->pluck('number')->all())->toBe([1, 2, 3]);
});

test('only a hunt that was won counts towards the hunters\' experience', function (): void {
    Event::fake(UserMonsterHunted::class);

    $this->put(route('campaigns.add-day', $this->campaign), hunt($this->monster, hunted: false))->assertSessionHasNoErrors();
    Event::assertNotDispatched(UserMonsterHunted::class);

    $this->put(route('campaigns.add-day', $this->campaign), hunt($this->monster, hunted: true));
    Event::assertDispatchedTimes(UserMonsterHunted::class, 1);
});

test('a day without a known type is refused', function (): void {
    $this->put(route('campaigns.add-day', $this->campaign), ['type_day' => 'FEAST'])
        ->assertSessionHasErrors('type_day', errorBag: 'addOrUpdateCampaignDay');

    expect($this->campaign->days()->count())->toBe(0);
});

test('a hunt needs a monster that exists and a known difficulty', function (): void {
    $this->put(route('campaigns.add-day', $this->campaign), [
        'type_day' => DayType::MONSTER->name,
        'monster_id' => 999,
        'difficulty' => 'NIGHTMARE',
    ])->assertSessionHasErrors(['monster_id', 'difficulty'], errorBag: 'addOrUpdateCampaignDay');

    expect($this->campaign->days()->count())->toBe(0);
});

test('a downtime day for the whole party gives every hunter the same activities', function (): void {
    $first = memberWithHunter($this->campaign);
    $second = memberWithHunter($this->campaign);
    $chosen = $this->activities->take(2)->pluck('id')->all();

    $this->put(route('campaigns.add-day', $this->campaign), [
        'type_day' => DayType::DOWNTIME->name,
        'all_hunters_same_activity' => true,
        'day_id' => $chosen,
    ])->assertSessionHasNoErrors();

    $day = $this->campaign->days()->sole();

    foreach ([$first, $second] as $hunter) {
        expect($day->hunters()->where('hunters.id', $hunter->id)->pluck('downtime_activity_id')->sort()->values()->all())
            ->toBe($chosen);
    }

    // The owner has no hunter, so nobody else gets rows, and with two
    // activities the single column cannot hold the answer.
    expect($day->hunters()->count())->toBe(4)
        ->and($day->downtime_activity_id)->toBeNull()
        ->and($day->all_hunters_same_activity)->toBeTruthy();
});

test('one shared activity is also written on the day itself', function (): void {
    memberWithHunter($this->campaign);

    $this->put(route('campaigns.add-day', $this->campaign), [
        'type_day' => DayType::DOWNTIME->name,
        'all_hunters_same_activity' => true,
        // The old single-id shape is still accepted.
        'day_id' => $this->activities[1]->id,
    ])->assertSessionHasNoErrors();

    expect($this->campaign->days()->sole()->downtime_activity_id)->toBe($this->activities[1]->id);
});

test('the whole party cannot repeat an activity in one day', function (): void {
    $this->put(route('campaigns.add-day', $this->campaign), [
        'type_day' => DayType::DOWNTIME->name,
        'all_hunters_same_activity' => true,
        'day_id' => [$this->activities[0]->id, $this->activities[0]->id],
    ])->assertSessionHasErrors('day_id.0', errorBag: 'addOrUpdateCampaignDay');
});

test('turning a downtime day into a hunt drops every hunter\'s activities', function (): void {
    $hunter = memberWithHunter($this->campaign);
    $this->put(route('campaigns.add-day', $this->campaign), [
        'type_day' => DayType::DOWNTIME->name,
        'all_hunters_same_activity' => true,
        'day_id' => [$this->activities[0]->id],
    ]);
    $day = $this->campaign->days()->sole();

    Event::fake(UserMonsterHunted::class);
    $this->put(route('campaigns.update-day', [$this->campaign, $day]), hunt($this->monster, hunted: true))
        ->assertSessionHasNoErrors();

    $day->refresh();

    expect($day->monster_id)->toBe($this->monster->id)
        ->and($day->difficulty)->not->toBeNull()
        ->and($day->downtime_activity_id)->toBeNull()
        ->and($day->hunters()->count())->toBe(0)
        ->and($hunter->days()->count())->toBe(0);
});

test('turning a hunt into a downtime day forgets the monster', function (): void {
    $hunter = memberWithHunter($this->campaign);
    Event::fake(UserMonsterHunted::class);
    $this->put(route('campaigns.add-day', $this->campaign), hunt($this->monster, hunted: true));
    $day = $this->campaign->days()->sole();

    $this->put(route('campaigns.update-day', [$this->campaign, $day]), [
        'type_day' => DayType::DOWNTIME->name,
        'all_hunters_same_activity' => false,
        'hunter_day_id' => [$hunter->id => [$this->activities[2]->id]],
    ])->assertSessionHasNoErrors();

    $day->refresh();

    expect($day->monster_id)->toBeNull()
        ->and($day->difficulty)->toBeNull()
        ->and((bool) $day->hunted)->toBeFalse()
        ->and($day->hunters()->pluck('downtime_activity_id')->all())->toBe([$this->activities[2]->id]);
});

test('a downtime day only records hunters of the same campaign', function (): void {
    $stranger = Hunter::factory()->create();

    $this->put(route('campaigns.add-day', $this->campaign), [
        'type_day' => DayType::DOWNTIME->name,
        'all_hunters_same_activity' => false,
        'hunter_day_id' => [$stranger->id => [$this->activities[0]->id]],
    ])->assertSessionHasErrors(errorBag: 'addOrUpdateCampaignDay');

    expect($stranger->days()->count())->toBe(0);
});

test('the potions a party carries stay between none and three', function (int $potions, bool $accepted): void {
    $this->campaign->update(['health_potions' => 2]);

    $response = $this->put(route('campaigns.update-potions', $this->campaign), ['health_potions' => $potions]);

    if ($accepted) {
        $response->assertSessionHasNoErrors();
        expect($this->campaign->fresh()->health_potions)->toBe($potions);
    } else {
        $response->assertSessionHasErrors('health_potions', errorBag: 'updateCampaign');
        expect($this->campaign->fresh()->health_potions)->toBe(2);
    }
})->with([
    'none left' => [0, true],
    'full' => [3, true],
    'below none' => [-1, false],
    'one too many' => [4, false],
]);
