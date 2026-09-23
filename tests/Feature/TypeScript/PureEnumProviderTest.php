<?php

// EnumTransformer only emits an enum it can write as a union of literals, and
// PhpEnumProvider only calls a *backed* enum valid for that. Seven of the nine
// enums here are pure, so they were dropped without a word. The frontend sees
// them through asKeyLabelObjectSelectable(), whose `key` is the case name, so
// the case name is the value to emit.

use App\Enum\DayType;
use App\Enum\AchievementType;
use App\Support\TypeScript\PureEnumProvider;
use Spatie\TypeScriptTransformer\PhpNodes\PhpClassNode;

test('a pure enum is a valid union', function (): void {
    $provider = new PureEnumProvider;

    expect($provider->isValidUnion(PhpClassNode::fromClassString(DayType::class)))->toBeTrue();
});

test('a pure enum resolves its cases to their names', function (): void {
    $cases = (new PureEnumProvider)->resolveCases(PhpClassNode::fromClassString(DayType::class));

    expect($cases)->toBe([
        ['name' => 'MONSTER', 'value' => 'MONSTER'],
        ['name' => 'DOWNTIME', 'value' => 'DOWNTIME'],
    ]);
});

test('a backed enum still resolves to its backing values', function (): void {
    $cases = (new PureEnumProvider)->resolveCases(PhpClassNode::fromClassString(AchievementType::class));

    expect(array_column($cases, 'value'))->toBe(['level', 'monster', 'weapon', 'armor']);
});
