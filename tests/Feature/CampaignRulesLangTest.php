<?php

use App\Enum\MonsterExpansion;

/**
 * `resources/lang/{en,es}/campaign-rules.php` is read as a list, not as a
 * string: the create form renders one bullet per entry from whichever locale
 * is active. Nothing about that fails loudly when the two files disagree, a
 * shorter list simply shows fewer rules, so the shapes are pinned here rather
 * than left to whoever edits one file and not the other.
 */
function campaignRules(string $locale): array
{
    return require resource_path("lang/$locale/campaign-rules.php");
}

test('every language declares the same campaign rules', function (): void {
    $en = campaignRules('en');
    $es = campaignRules('es');

    expect(array_keys($es))->toEqual(array_keys($en))
        ->and($en['downtime'])->not->toBeEmpty()
        ->and($es['downtime'])->toHaveCount(count($en['downtime']))
        ->and(array_keys($es['expansions']))->toEqual(array_keys($en['expansions']));

    foreach ($en['expansions'] as $expansion => $rules) {
        expect($rules)->not->toBeEmpty()
            ->and($es['expansions'][$expansion])->toHaveCount(count($rules));
    }
});

test('every campaign rule is a non empty string', function (): void {
    foreach (['en', 'es'] as $locale) {
        $rules = campaignRules($locale);

        foreach ([$rules['downtime'], ...array_values($rules['expansions'])] as $list) {
            foreach ($list as $rule) {
                expect($rule)->toBeString()->not->toBeEmpty();
            }
        }
    }
});

test('every expansion the rules name still exists', function (): void {
    // The file keys by the enum case's name rather than by the enum itself, so
    // renaming a case leaves the rules behind without anything complaining:
    // the create form just stops finding them for that expansion.
    $cases = array_map(fn (MonsterExpansion $case): string => $case->name, MonsterExpansion::cases());

    expect(array_diff(array_keys(campaignRules('en')['expansions']), $cases))->toBeEmpty();
});

test('the create form is given the expansions the rules are keyed by', function (): void {
    $this->actingAs(App\Models\User::factory()->withPersonalTeam()->create());

    $this->get(route('campaigns.create'))->assertInertia(
        fn (Inertia\Testing\AssertableInertia $page) => $page
            ->has('expansions', count(MonsterExpansion::cases()))
            ->where('expansions.0.key', MonsterExpansion::cases()[0]->name)
    );
});
