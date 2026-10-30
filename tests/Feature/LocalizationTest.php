<?php

use App\Models\Item;
use App\Models\User;
use Inertia\Testing\AssertableInertia;

// Which language a page is served in: the one picked from the menu, else the
// browser's, else English. Translated model names follow it.

beforeEach(function (): void {
    $this->actingAs(User::factory()->withPersonalTeam()->create());
    $this->item = Item::factory()->create(['name' => ['en' => 'Monster Bone', 'es' => 'Hueso de monstruo']]);
});

test('the browser\'s language is used when nothing was picked', function (): void {
    $this->withHeader('Accept-Language', 'es-ES,es;q=0.9')
        ->get(route('wiki.item.show', $this->item))
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->where('locale', 'es')
            ->where('item.name', 'Hueso de monstruo'));
});

test('a browser language the app does not carry falls back to English', function (): void {
    $this->withHeader('Accept-Language', 'fr-FR,fr;q=0.9')
        ->get(route('wiki.item.show', $this->item))
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->where('locale', 'en')
            ->where('item.name', 'Monster Bone'));
});

test('the language picked from the menu wins over the browser and is remembered', function (): void {
    $this->from(route('wiki.index'))
        ->get(route('language', 'es'))
        ->assertRedirect(route('wiki.index'));

    $this->withHeader('Accept-Language', 'en-GB')
        ->get(route('wiki.item.show', $this->item))
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->where('locale', 'es')
            ->where('item.name', 'Hueso de monstruo'));
});

test('switching language without a previous page lands on the welcome page', function (): void {
    $this->get(route('language', 'en'))->assertRedirect(route('welcome'));
});
