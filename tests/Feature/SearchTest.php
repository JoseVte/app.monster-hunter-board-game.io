<?php

use App\Models\User;
use Inertia\Testing\AssertableInertia;

beforeEach(function (): void {
    $this->actingAs(User::factory()->withPersonalTeam()->create());
});

test('search renders the search page with the submitted query', function (): void {
    $response = $this->get(route('search', ['query' => 'rathalos']));

    $response->assertStatus(200);
    $response->assertInertia(
        fn (AssertableInertia $page) => $page
            ->component('Search')
            ->where('query', 'rathalos')
            ->has('results')
    );
});

test('search renders without a query', function (): void {
    $response = $this->get(route('search'));

    $response->assertStatus(200);
    $response->assertInertia(
        fn (AssertableInertia $page) => $page
            ->component('Search')
            ->where('query', null)
    );
});

test('global search returns json without a keyword', function (): void {
    $response = $this->get(route('global-search'));

    $response->assertStatus(200);
    $response->assertExactJson([]);
});

test('global search returns json', function (): void {
    $response = $this->get(route('global-search', ['keyword' => 'rathalos']));

    $response->assertStatus(200);
    $response->assertHeader('content-type', 'application/json');
});

test('search requires authentication', function (): void {
    auth()->logout();

    $response = $this->get(route('search', ['query' => 'rathalos']));

    $response->assertRedirect(route('login'));
});
