<?php

namespace App\Enum;

use App\Enum\Traits\TranslatableEnum;
use App\Enum\Contracts\TranslatableEnum as TranslatableEnumContract;

enum MonsterCategory implements TranslatableEnumContract
{
    use TranslatableEnum;

    case FANGED_WYVERN;
    case PISCINE_WYVERN;
    case BIRD_WYVERN;
    case FLYING_WYVERN;
    case BRUTE_WYVERN;
    case ELDER_DRAGON;

    public function label(string $locale = null): string
    {
        return match ($this) {
            self::FANGED_WYVERN => __('Fanged Wyvern', [], $locale),
            self::PISCINE_WYVERN => __('Piscine Wyvern', [], $locale),
            self::BIRD_WYVERN => __('Bird Wyvern', [], $locale),
            self::FLYING_WYVERN => __('Flying Wyvern', [], $locale),
            self::BRUTE_WYVERN => __('Brute Wyvern', [], $locale),
            self::ELDER_DRAGON => __('Elder Dragon', [], $locale),
        };
    }
}
