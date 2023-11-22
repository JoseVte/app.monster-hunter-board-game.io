<?php

namespace App\Enum;

use App\Enum\Traits\TranslatableEnum;
use App\Enum\Contracts\TranslatableEnum as TranslatableEnumContract;

enum DeviationWeapon implements TranslatableEnumContract
{
    use TranslatableEnum;

    case NONE;
    case LOW;
    case AVERAGE;
    case HIGH;

    public function label(string $locale = null): string
    {
        return match ($this) {
            self::NONE => __('None', [], $locale),
            self::LOW => __('Low', [], $locale),
            self::AVERAGE => __('Average', [], $locale),
            self::HIGH => __('High', [], $locale),
        };
    }
}
