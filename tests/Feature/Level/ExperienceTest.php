<?php

use App\Models\User;
use App\Models\Achievement;
use App\Enum\AchievementType;
use App\Events\UserLevelledUp;
use Illuminate\Support\Facades\Event;

test('a new user starts at level one with no points', function (): void {
    $user = User::factory()->create();

    expect($user->getLevel())->toEqual(1)
        ->and($user->getPoints())->toEqual(0);
});

test('a new user is granted every achievement', function (): void {
    $user = User::factory()->create();

    expect($user->achievements()->count())->toEqual(Achievement::count());
});

test('level achievements start at the progress the level implies', function (): void {
    $user = User::factory()->create();

    $levelTen = Achievement::where('slug', 'level-10')->firstOrFail();

    expect($user->achievements()->find($levelTen->id)->pivot->progress)->toEqual(10);
});

test('achievements that are not about levels start at zero', function (): void {
    $user = User::factory()->create();

    $achievement = Achievement::where('type', AchievementType::WEAPON)->firstOrFail();

    expect($user->achievements()->find($achievement->id)->pivot->progress)->toEqual(0);
});

test('points below the next threshold do not change the level', function (): void {
    $user = User::factory()->create();

    $user->addPoints(49);

    expect($user->fresh()->getPoints())->toEqual(49)
        ->and($user->fresh()->getLevel())->toEqual(1);
});

test('crossing a threshold levels the user up', function (): void {
    $user = User::factory()->create();

    $user->addPoints(50);

    expect($user->fresh()->getLevel())->toEqual(2);
});

test('a single award can cross several levels at once', function (): void {
    $user = User::factory()->create();

    $user->addPoints(200);

    expect($user->fresh()->getLevel())->toEqual(5);
});

test('levelling up fires one event per level gained', function (): void {
    $user = User::factory()->create();

    Event::fake([UserLevelledUp::class]);

    $user->addPoints(200);

    Event::assertDispatchedTimes(UserLevelledUp::class, 4);
});

test('nextLevelAt reports the points still missing', function (): void {
    $user = User::factory()->create();

    $user->addPoints(50);

    expect($user->fresh()->nextLevelAt())->toEqual(25);
});

test('nextLevelAt reports progress as a percentage', function (): void {
    $user = User::factory()->create();

    $user->addPoints(50);

    expect($user->fresh()->nextLevelAt(null, true))->toEqual(0);

    $user->fresh()->addPoints(13);

    expect($user->fresh()->nextLevelAt(null, true))->toEqual(52);
});

test('the level curve grows by adding the two previous requirements', function (): void {
    $requirements = App\Models\Level::orderBy('level')
        ->limit(6)
        ->pluck('next_level_experience')
        ->all();

    expect($requirements)->toEqual([null, 50, 75, 125, 200, 325]);
});

test('deleting a user clears their experience', function (): void {
    $user = User::factory()->create();
    $user->addPoints(50);

    $user->delete();

    expect(App\Models\Experience::where('user_id', $user->id)->exists())->toBeFalse();
});
