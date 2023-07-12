<?php

namespace App\Enum;

use App\Enum\Traits\TranslatableEnum;
use App\Enum\Contracts\TranslatableEnum as TranslatableEnumContract;

enum MonsterDifficulty implements TranslatableEnumContract
{
    use TranslatableEnum;

    case EASY;
    case NORMAL;
    case HARD;
    case ARENA_EASY;
    case ARENA_NORMAL;
    case ARENA_HARD;

    public function label(string $locale = null): string
    {
        return match ($this) {
            self::EASY => __('Easy', [], $locale),
            self::NORMAL => __('Normal', [], $locale),
            self::HARD => __('Hard', [], $locale),
            self::ARENA_EASY => __('Arena Easy', [], $locale),
            self::ARENA_NORMAL => __('Arena Normal', [], $locale),
            self::ARENA_HARD => __('Arena Hard', [], $locale),
        };
    }
}
