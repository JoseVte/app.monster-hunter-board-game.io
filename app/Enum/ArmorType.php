<?php

namespace App\Enum;

use App\Enum\Contracts\TranslatableEnum as TranslatableEnumContract;
use App\Enum\Traits\TranslatableEnum;

enum ArmorType implements TranslatableEnumContract
{
    use TranslatableEnum;

    case HEAD;
    case BODY;
    case LEG;

    public function label(string $locale = null): string
    {
        return match ($this) {
            self::HEAD => __('Head', [], $locale),
            self::BODY => __('Body', [], $locale),
            self::LEG => __('Leg', [], $locale),
        };
    }
}
