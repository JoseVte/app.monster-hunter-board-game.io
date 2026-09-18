<?php

use App\Models\Day;
use App\Models\User;
use App\Models\Armor;
use App\Models\Craft;
use App\Models\Hunter;
use App\Models\Weapon;
use App\Models\Monster;
use App\Models\Campaign;
use App\Enum\MonsterDifficulty;
use App\Events\UserMonsterHunted;
use App\Events\UserEquipmentCrafted;

beforeEach(function (): void {
    $this->user = User::factory()->withPersonalTeam()->create();
    $this->campaign = Campaign::factory()->create(['team_id' => $this->user->currentTeam->id]);
    $this->hunter = Hunter::factory()->create(['campaign_id' => $this->campaign->id]);
    $this->campaign->users()->updateExistingPivot($this->user->id, ['hunter_id' => $this->hunter->id]);
});

function progressOf(User $user, string $slug): int
{
    return $user->achievements()->where('slug', $slug)->first()->pivot->progress;
}

function craftWeapon(Hunter $hunter, User $user): void
{
    $weapon = Weapon::factory()->create();
    $hunter->weapons()->attach($weapon);

    event(new UserEquipmentCrafted($user, $weapon));
}

function craftArmor(Hunter $hunter, User $user): void
{
    $armor = Armor::factory()->create();
    $hunter->armors()->attach($armor);

    event(new UserEquipmentCrafted($user, $armor));
}

function huntMonster(Campaign $campaign, int $number): void
{
    $day = Day::factory()->create([
        'campaign_id' => $campaign->id,
        'number' => $number,
        'monster_id' => Monster::factory()->create()->id,
        'difficulty' => MonsterDifficulty::EASY,
        'hunted' => true,
    ]);

    event(new UserMonsterHunted($campaign, $day));
}

test('a new user starts every equipment achievement at zero progress', function (): void {
    expect(progressOf($this->user, 'craft-weapon-1'))->toEqual(0)
        ->and(progressOf($this->user, 'craft-armor-10'))->toEqual(0)
        ->and(progressOf($this->user, 'monsters-25'))->toEqual(0);
});

test('crafting a weapon awards experience equal to its rarity', function (): void {
    $weapon = Weapon::factory()->create(['rarity' => 5]);
    $pointsBefore = $this->user->getPoints();

    event(new UserEquipmentCrafted($this->user, $weapon));

    expect($this->user->fresh()->getPoints())->toEqual($pointsBefore + 5);
});

test('crafting an armor awards experience equal to its rarity', function (): void {
    $armor = Armor::factory()->create(['rarity' => 3]);
    $pointsBefore = $this->user->getPoints();

    event(new UserEquipmentCrafted($this->user, $armor));

    expect($this->user->fresh()->getPoints())->toEqual($pointsBefore + 3);
});

test('crafting a weapon completes the single step weapon achievement', function (): void {
    craftWeapon($this->hunter, $this->user);

    expect(progressOf($this->user, 'craft-weapon-1'))->toEqual(100);
});

test('crafting a weapon leaves the armor achievements untouched', function (): void {
    craftWeapon($this->hunter, $this->user);

    expect(progressOf($this->user, 'craft-armor-1'))->toEqual(0)
        ->and(progressOf($this->user, 'craft-armor-10'))->toEqual(0);
});

test('crafting an armor leaves the weapon achievements untouched', function (): void {
    craftArmor($this->hunter, $this->user);

    expect(progressOf($this->user, 'craft-weapon-1'))->toEqual(0)
        ->and(progressOf($this->user, 'craft-weapon-10'))->toEqual(0);
});

test('every crafted weapon advances the progress', function (): void {
    craftWeapon($this->hunter, $this->user);
    expect(progressOf($this->user, 'craft-weapon-10'))->toEqual(10);

    craftWeapon($this->hunter, $this->user);
    expect(progressOf($this->user, 'craft-weapon-10'))->toEqual(20);

    craftWeapon($this->hunter, $this->user);
    expect(progressOf($this->user, 'craft-weapon-10'))->toEqual(30);
});

test('crafting ten weapons completes the ten step achievement', function (): void {
    foreach (range(1, 10) as $ignored) {
        craftWeapon($this->hunter, $this->user);
    }

    expect(progressOf($this->user, 'craft-weapon-10'))->toEqual(100)
        ->and(progressOf($this->user, 'craft-weapon-25'))->toEqual(40);
});

test('the progress never goes above one hundred', function (): void {
    foreach (range(1, 12) as $ignored) {
        craftWeapon($this->hunter, $this->user);
    }

    expect(progressOf($this->user, 'craft-weapon-10'))->toEqual(100);
});

test('crafted armors are counted separately from weapons', function (): void {
    craftWeapon($this->hunter, $this->user);
    craftArmor($this->hunter, $this->user);
    craftArmor($this->hunter, $this->user);

    expect(progressOf($this->user, 'craft-weapon-10'))->toEqual(10)
        ->and(progressOf($this->user, 'craft-armor-10'))->toEqual(20);
});

test('hunting a monster awards experience to every campaign member', function (): void {
    $day = Day::factory()->create([
        'campaign_id' => $this->campaign->id,
        'number' => 1,
        'monster_id' => Monster::factory()->create()->id,
        'difficulty' => MonsterDifficulty::HARD,
        'hunted' => true,
    ]);
    $pointsBefore = $this->user->getPoints();

    event(new UserMonsterHunted($this->campaign, $day));

    expect($this->user->fresh()->getPoints())
        ->toEqual($pointsBefore + MonsterDifficulty::HARD->experience());
});

test('a harder monster is worth more experience than an easier one', function (): void {
    expect(MonsterDifficulty::HARD->experience())
        ->toBeGreaterThan(MonsterDifficulty::NORMAL->experience())
        ->and(MonsterDifficulty::NORMAL->experience())
        ->toBeGreaterThan(MonsterDifficulty::EASY->experience());
});

test('every hunted monster advances the monster achievements', function (): void {
    huntMonster($this->campaign, 1);
    expect(progressOf($this->user, 'monsters-1'))->toEqual(100)
        ->and(progressOf($this->user, 'monsters-10'))->toEqual(10);

    huntMonster($this->campaign, 2);
    expect(progressOf($this->user, 'monsters-10'))->toEqual(20)
        ->and(progressOf($this->user, 'monsters-25'))->toEqual(8);
});

test('a day that was not hunted does not count', function (): void {
    Day::factory()->create([
        'campaign_id' => $this->campaign->id,
        'number' => 1,
        'monster_id' => Monster::factory()->create()->id,
        'difficulty' => MonsterDifficulty::EASY,
        'hunted' => false,
    ]);

    huntMonster($this->campaign, 2);

    expect(progressOf($this->user, 'monsters-10'))->toEqual(10);
});

test('upgrading a weapon still advances the progress', function (): void {
    // An upgrade replaces the weapon it was made from, so counting what a hunter
    // owns leaves the progress flat no matter how much they craft.
    $parent = Weapon::factory()->create();
    $this->hunter->weapons()->attach($parent);
    event(new UserEquipmentCrafted($this->user, $parent));

    expect(progressOf($this->user, 'craft-weapon-10'))->toEqual(10);

    $child = Weapon::factory()->create(['parent_id' => $parent->id]);
    $this->hunter->weapons()->detach($parent->id);
    $this->hunter->weapons()->attach($child);
    event(new UserEquipmentCrafted($this->user, $child));

    expect(progressOf($this->user, 'craft-weapon-10'))->toEqual(20);
});

test('each craft is recorded, and deleting the user takes them with it', function (): void {
    craftWeapon($this->hunter, $this->user);
    craftArmor($this->hunter, $this->user);

    expect($this->user->crafts()->count())->toEqual(2)
        ->and($this->user->craftedWeaponsCount())->toEqual(1)
        ->and($this->user->craftedArmorsCount())->toEqual(1);

    $userId = $this->user->id;
    $this->user->delete();

    expect(Craft::where('user_id', $userId)->exists())->toBeFalse();
});

test('a weapon and an armour of the same id are counted apart', function (): void {
    // The log is polymorphic, so nothing but the type keeps these two apart.
    $weapon = Weapon::factory()->create();
    $armor = Armor::factory()->create(['id' => $weapon->id]);

    $this->hunter->weapons()->attach($weapon);
    event(new UserEquipmentCrafted($this->user, $weapon));

    $this->hunter->armors()->attach($armor);
    event(new UserEquipmentCrafted($this->user, $armor));

    expect($this->user->craftedWeaponsCount())->toEqual(1)
        ->and($this->user->craftedArmorsCount())->toEqual(1);
});
