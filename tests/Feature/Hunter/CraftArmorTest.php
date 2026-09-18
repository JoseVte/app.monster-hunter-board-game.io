<?php

use App\Models\Item;
use App\Models\User;
use App\Models\Armor;
use App\Models\Hunter;
use App\Models\Campaign;

beforeEach(function (): void {
    $this->actingAs($this->user = User::factory()->withPersonalTeam()->create());
    $this->campaign = Campaign::factory()->create(['team_id' => $this->user->currentTeam->id]);
    $this->hunter = Hunter::factory()->create(['campaign_id' => $this->campaign->id]);

    $this->hide = Item::factory()->create(['name' => ['en' => 'Anja Hide', 'es' => 'Piel de Anja']]);
    $this->armor = Armor::factory()->create(['is_default' => false]);
    $this->armor->items()->attach($this->hide, ['number' => 2]);
    $this->armor->load('items');

    $this->craft = fn () => $this->post(
        route('campaigns.hunters.armors.craft', [$this->campaign, $this->hunter, $this->armor]),
    );

    $this->giveParts = function (int $number): void {
        $this->hunter->items()->attach($this->hide, ['number' => $number]);
        $this->hunter->load('items');
    };
});

test('a hunter with the parts can craft an armor', function (): void {
    ($this->giveParts)(2);

    expect($this->hunter->canCraftArmor($this->armor))->toBeTrue();

    ($this->craft)()->assertStatus(303);

    expect($this->hunter->fresh()->armors)->toHaveCount(1);
});

test('an armor already owned cannot be crafted again', function (): void {
    // Armours have no upgrade tree the way weapons do, so a second copy buys
    // nothing and only spends the parts.
    ($this->giveParts)(4);
    $this->hunter->armors()->attach($this->armor);
    $this->hunter->load('armors');

    expect($this->hunter->canCraftArmor($this->armor))->toBeFalse();

    ($this->craft)()->assertStatus(400);

    expect($this->hunter->fresh()->armors)->toHaveCount(1);
});

test('crafting a second copy does not spend the parts', function (): void {
    ($this->giveParts)(4);
    $this->hunter->armors()->attach($this->armor);
    $this->hunter->load('armors');

    ($this->craft)();

    expect($this->hunter->fresh()->items->firstWhere('id', $this->hide->id)->pivot->number)->toBe(4);
});

test('a hunter without the parts cannot craft', function (): void {
    ($this->giveParts)(1);

    expect($this->hunter->canCraftArmor($this->armor))->toBeFalse();
});
