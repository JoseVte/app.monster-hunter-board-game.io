<?php

namespace App\Support\TypeScript;

use Spatie\TypeScriptTransformer\PhpNodes\PhpEnumNode;
use Spatie\TypeScriptTransformer\PhpNodes\PhpClassNode;
use Spatie\TypeScriptTransformer\Transformers\EnumProviders\PhpEnumProvider;

/**
 * The same enum provider Spatie ships, minus its refusal to write a pure enum
 * as a union.
 *
 * Its isValidUnion() requires a backed enum, so DayType, ArmorType,
 * MonsterDifficulty, MonsterCategory, MonsterExpansion, ItemType and
 * DeviationWeapon were emitted nowhere at all. A pure enum has no backing
 * value, and the one the frontend actually sees is the case name:
 * TranslatableEnum::asKeyLabelObjectSelectable() sends `key => $enum->name`.
 */
class PureEnumProvider extends PhpEnumProvider
{
    public function isValidUnion(PhpClassNode $phpClassNode): bool
    {
        return $this->isEnum($phpClassNode);
    }

    // PhpEnumProvider widens this to PhpClassNode|PhpEnumNode. Narrowing a
    // parameter against the parent is a fatal error, so the union is repeated.
    public function resolveCases(PhpClassNode|PhpEnumNode $phpClassNode): array
    {
        return array_map(
            fn (array $case): array => [
                'name' => $case['name'],
                'value' => $case['value'] ?? $case['name'],
            ],
            parent::resolveCases($phpClassNode),
        );
    }
}
