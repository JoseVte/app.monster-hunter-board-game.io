<?php

use App\Models\Item;
use App\Models\User;
use App\Models\Hunter;
use App\Models\Campaign;

beforeEach(function (): void {
    $this->actingAs($this->user = User::factory()->withPersonalTeam()->create());
    $this->campaign = Campaign::factory()->create(['team_id' => $this->user->currentTeam->id]);
    $this->hunter = Hunter::factory()->create(['campaign_id' => $this->campaign->id]);

    $this->hide = Item::factory()->create();
    $this->claw = Item::factory()->create();

    $this->add = fn (array $items) => $this->put(
        route('campaigns.hunters.items.store-many', [$this->campaign, $this->hunter]),
        ['items' => $items],
    );
});

test('a hunter takes several parts in one go', function (): void {
    // A hunt yields a handful of parts at once, and opening the modal once per
    // part is the whole reason this exists.
    ($this->add)([
        ['item_id' => $this->hide->id, 'number' => 3],
        ['item_id' => $this->claw->id, 'number' => 2],
    ])->assertStatus(303);

    $items = $this->hunter->fresh()->items;

    expect($items->firstWhere('id', $this->hide->id)->pivot->number)->toBe(3)
        ->and($items->firstWhere('id', $this->claw->id)->pivot->number)->toBe(2);
});

test('a count replaces what the hunter already had of that part', function (): void {
    $this->hunter->items()->attach($this->hide, ['number' => 1]);

    ($this->add)([['item_id' => $this->hide->id, 'number' => 5]]);

    expect($this->hunter->fresh()->items->firstWhere('id', $this->hide->id)->pivot->number)->toBe(5);
});

test('an empty list is refused', function (): void {
    ($this->add)([])->assertSessionHasErrors('items');
});

test('a part that does not exist is refused', function (): void {
    ($this->add)([['item_id' => 99999, 'number' => 1]])->assertSessionHasErrors('items.0.item_id');
});

test('a negative count is refused', function (): void {
    ($this->add)([['item_id' => $this->hide->id, 'number' => -1]])->assertSessionHasErrors('items.0.number');
});

test('a hunter outside the campaign cannot add', function (): void {
    $this->actingAs(User::factory()->withPersonalTeam()->create());

    ($this->add)([['item_id' => $this->hide->id, 'number' => 1]])->assertStatus(403);
});
