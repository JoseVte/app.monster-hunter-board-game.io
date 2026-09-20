<?php

use App\Models\User;

// Nothing covered these before. They matter more than their size suggests: the
// only link to them used to be the checkbox on the registration form, and
// registration is closed by default, so the documents the cookie notice and the
// terms both point at were unreachable to a visitor.

test('the legal pages are public', function (string $route): void {
    $this->get(route($route))->assertOk();
})->with(['policy.show', 'terms.show']);

test('the legal pages render their own component', function (string $route, string $component, string $prop): void {
    $this->get(route($route))
        ->assertInertia(fn ($page) => $page->component($component)->has($prop));
})->with([
    ['policy.show', 'PrivacyPolicy', 'policy'],
    ['terms.show', 'TermsOfService', 'terms'],
]);

// Jetstream::localizedMarkdownPath() looks for policy.<locale>.md and falls back
// to policy.md, so a missing translation degrades silently into English rather
// than failing. Pinning both directions is what makes that visible.
// The assertions use a phrase from the body of the document rather than its
// title. "Privacy Policy" also travels to the page inside the i18n catalogue,
// so asserting on the title would pass in either language and prove nothing.
// The phrases carry no accented characters on purpose: the Inertia payload is
// JSON and escapes them, so a match on "terminos" would fail for the wrong
// reason.
test('the legal pages follow the locale', function (string $route, string $english, string $spanish): void {
    expect($this->get(route($route))->getContent())
        ->toContain($english)
        ->not->toContain($spanish);

    $this->get(route('language', 'es'));

    expect($this->get(route($route))->getContent())
        ->toContain($spanish)
        ->not->toContain($english);
})->with([
    ['policy.show', 'is the data controller', 'es el responsable del tratamiento'],
    ['terms.show', 'By creating an account you accept them', 'Al crear una cuenta los aceptas'],
]);

test('a signed in user can still read them', function (string $route): void {
    $this->actingAs(User::factory()->withPersonalTeam()->create())
        ->get(route($route))
        ->assertOk();
})->with(['policy.show', 'terms.show']);
