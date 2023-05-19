<?php

namespace App\Enum;

use App\Enum\Contracts\TranslatableEnum as TranslatableEnumContract;
use App\Enum\Traits\TranslatableEnum;

enum ItemType implements TranslatableEnumContract
{
    use TranslatableEnum;

    case COMMON;
    case OTHER;
    case MONSTER_PART;

    public function label(string $locale = null): string
    {
        return match ($this) {
            self::COMMON => __('Common', [], $locale),
            self::OTHER => __('Other', [], $locale),
            self::MONSTER_PART => __('Monster Part', [], $locale),
        };
    }
}
