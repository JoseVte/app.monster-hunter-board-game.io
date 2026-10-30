<?php

use App\Models\User;
use Illuminate\Support\Facades\Notification;
use Illuminate\Auth\Notifications\VerifyEmail;

// A new address has to be proved again; a new name alone does not touch it.

test('renaming keeps the address verified and sends nothing', function (): void {
    Notification::fake();
    $this->actingAs($user = User::factory()->create(['email' => 'hunter@example.com']));

    $this->put('/user/profile-information', ['name' => 'Renamed', 'email' => 'hunter@example.com'])
        ->assertSessionHasNoErrors();

    expect($user->fresh()->name)->toBe('Renamed')
        ->and($user->fresh()->hasVerifiedEmail())->toBeTrue();
    Notification::assertNothingSent();
});

test('a new address has to be verified again', function (): void {
    Notification::fake();
    $this->actingAs($user = User::factory()->create(['email' => 'hunter@example.com']));

    $this->put('/user/profile-information', ['name' => $user->name, 'email' => 'new@example.com'])
        ->assertSessionHasNoErrors();

    expect($user->fresh()->email)->toBe('new@example.com')
        ->and($user->fresh()->hasVerifiedEmail())->toBeFalse();
    Notification::assertSentTo($user, VerifyEmail::class);
});

test('an address another account uses is refused', function (): void {
    User::factory()->create(['email' => 'taken@example.com']);
    $this->actingAs($user = User::factory()->create(['email' => 'hunter@example.com']));

    $this->put('/user/profile-information', ['name' => $user->name, 'email' => 'taken@example.com'])
        ->assertSessionHasErrors('email', errorBag: 'updateProfileInformation');

    expect($user->fresh()->email)->toBe('hunter@example.com');
});
