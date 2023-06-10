<?php

use App\Models\Item;
use App\Models\User;
use App\Models\Hunter;
use App\Models\Campaign;

beforeEach(function (): void {
    $this->actingAs($this->user = User::factory()->withPersonalTeam()->create());
    $this->campaign = Campaign::factory()->create(['team_id' => $this->user->currentTeam->id]);
    $this->hunter = Hunter::factory()->create(['campaign_id' => $this->campaign->id]);
    $this->item = Item::factory()->create();
});

test('hunter can see edit page', function (): void {
    $response = $this->get(route('campaigns.hunters.edit', [$this->campaign, $this->hunter]));
    $response->assertStatus(200);
});

test('hunter can update', function (): void {
    $response = $this->put(route('campaigns.hunters.update', [$this->campaign, $this->hunter]), [
        'name' => 'Test Hunter',
    ]);
    $response->assertStatus(303);

    $this->hunter->refresh();
    $this->assertEquals('Test Hunter', $this->hunter->name);
});

test('hunter can update common items', function (): void {
    $response = $this->put(route('campaigns.hunters.items.update-count', [$this->campaign, $this->hunter, $this->item]), [
        'count_item' => 10,
    ]);
    $response->assertStatus(303);

    $this->assertEquals(1, $this->hunter->items()->count());
    $this->assertEquals(10, $this->hunter->items()->first()->pivot->number);
});
