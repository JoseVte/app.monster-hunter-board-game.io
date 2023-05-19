<?php

namespace App\Enum;

use App\Enum\Contracts\TranslatableEnum as TranslatableEnumContract;
use App\Enum\Traits\TranslatableEnum;

enum MonsterExpansion implements TranslatableEnumContract
{
    use TranslatableEnum;

    case ANCIENT_FOREST;
    case WILDSPIRE_WASTE;
    case KULU_YA_KU_EXPANSION;
    case TEOSTRA_EXPANSION;
    case NERGIGANTE_EXPANSION;
    case KUSHALA_EXPANSION;

    public function label(string $locale = null): string
    {
        return match ($this) {
            self::ANCIENT_FOREST => __('Ancient Forest', [], $locale),
            self::WILDSPIRE_WASTE => __('Wildspire Waste', [], $locale),
            self::KULU_YA_KU_EXPANSION => __('Kulu-Ya-Ku Expansion', [], $locale),
            self::TEOSTRA_EXPANSION => __('Teostra Expansion', [], $locale),
            self::NERGIGANTE_EXPANSION => __('Nergigante Expansion', [], $locale),
            self::KUSHALA_EXPANSION => __('Kushala Expansion', [], $locale),
        };
    }
}
