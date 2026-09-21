<?php

use App\Models\User;
use App\Models\Invitation;
use Illuminate\Support\Facades\Artisan;

// This is how the first account on a fresh database gets in. Registration is
// closed by default and the seeders no longer invent an admin, so without it a
// rebuilt production database has no door at all.

test('it issues an invitation that nobody signed', function (): void {
    $this->artisan('invitation:create')->assertSuccessful();

    $invitation = Invitation::sole();

    expect($invitation->inviter_id)->toBeNull()
        ->and($invitation->email)->toBeNull()
        ->and($invitation->status)->toEqual('pending');
});

test('it locks the invitation to an address when given one', function (): void {
    $this->artisan('invitation:create', ['email' => 'jane@example.com'])->assertSuccessful();

    expect(Invitation::sole()->email)->toEqual('jane@example.com');
});

test('it can issue one on behalf of an existing user', function (): void {
    $inviter = User::factory()->withPersonalTeam()->create();

    $this->artisan('invitation:create', ['--from' => $inviter->email])->assertSuccessful();

    expect(Invitation::sole()->inviter_id)->toEqual($inviter->id);
});

test('it refuses an inviter that does not exist', function (): void {
    $this->artisan('invitation:create', ['--from' => 'nobody@example.com'])->assertFailed();

    expect(Invitation::count())->toBe(0);
});

// The token is printed once because only its hash is stored. A link that does
// not open is the same as no link at all, so this walks the one it prints.
// withoutMockingConsoleOutput is what makes Artisan::output() hold anything;
// the mocked console the test helper installs by default swallows it.
test('the link it prints opens the acceptance form', function (): void {
    $this->withoutMockingConsoleOutput();

    Artisan::call('invitation:create', ['email' => 'jane@example.com']);

    $link = collect(explode("\n", Artisan::output()))
        ->map(fn (string $line): string => trim($line))
        ->first(fn (string $line): bool => str_contains($line, '/invite/'));

    expect($link)->not->toBeNull();

    $this->get($link)->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('Auth/AcceptInvitation')
            ->where('email', 'jane@example.com')
            ->where('inviter', config('app.name')));
});
