<?php

namespace App\Enum;

use App\Enum\Traits\TranslatableEnum;
use App\Enum\Contracts\TranslatableEnum as TranslatableEnumContract;

enum DayType implements TranslatableEnumContract
{
    use TranslatableEnum;

    case MONSTER;
    case DOWNTIME;

    public function label(string $locale = null): string
    {
        return match ($this) {
            self::MONSTER => __('Hunt a monster', [], $locale),
            self::DOWNTIME => __('Downtime activity', [], $locale),
        };
    }
}
