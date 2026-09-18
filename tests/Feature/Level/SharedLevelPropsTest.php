<?php

use App\Models\User;

test('every page is handed the current level, points and progress', function (): void {
    $user = User::factory()->withPersonalTeam()->create();
    $user->addPoints(120);

    $this->actingAs($user->fresh())
        ->get(route('dashboard'))
        ->assertInertia(fn ($page) => $page
            ->where('level.current', 3)
            ->where('level.points', 120)
            ->where('level.next', 5)
            ->where('level.next_percentage', 90));
});

test('a user with no experience record does not break the shared props', function (): void {
    $user = User::factory()->withPersonalTeam()->create();
    $user->experience()->delete();

    $this->actingAs($user->fresh())
        ->get(route('dashboard'))
        ->assertInertia(fn ($page) => $page
            ->where('level.current', 0)
            ->where('level.points', 0)
            ->where('level.next', 0)
            ->where('level.next_percentage', 0));
});

test('the level page lists every achievement with the progress the user has', function (): void {
    $user = User::factory()->withPersonalTeam()->create();

    $this->actingAs($user)
        ->get(route('profile.level'))
        ->assertInertia(fn ($page) => $page
            ->component('Profile/Level')
            ->has('achievements', 18)
            ->has('user.achievements', 18));
});
