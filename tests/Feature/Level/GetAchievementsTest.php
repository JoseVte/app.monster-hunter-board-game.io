<?php

use App\Models\User;
use LevelUp\Experience\Models\Achievement;

beforeEach(function (): void {
    $this->actingAs($this->user = User::factory()->withPersonalTeam()->create());
});

test('user can see achievement page', function (): void {
    $response = $this->get(route('profile.level'));
    $response->assertStatus(200);

    expect($this->user->achievements()->count())->toEqual(Achievement::count());
});

test('user level up give the achievement', function (): void {
    $this->user->addPoints(2500);

    expect($this->user->achievements()->where('slug', 'level-10')->first()->pivot->progress)->toEqual(100)
        ->and($this->user->achievements()->where('slug', 'level-25')->first()->pivot->progress)->toEqual(40);

    $this->user2 = User::factory()->withPersonalTeam()->create();
    $this->user2->addPoints(275000);

    expect($this->user2->getLevel())->toEqual(20)
        ->and($this->user2->achievements()->where('slug', 'level-25')->first()->pivot->progress)->toEqual(80)
        ->and($this->user2->achievements()->where('slug', 'level-50')->first()->pivot->progress)->toEqual(40);
});
