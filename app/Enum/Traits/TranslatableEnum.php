<?php

namespace App\Enum\Traits;

use App\Enum\Contracts\TranslatableEnum as TranslatableEnumContract;

trait TranslatableEnum
{
    public static function asSelectable(): array
    {
        return collect(self::cases())
            ->keyBy(fn (TranslatableEnumContract $enum) => $enum->name)
            ->map(fn (TranslatableEnumContract $enum) => $enum->label())
            ->toArray();
    }

    public function getTranslations(): array
    {
        $translations = [];
        foreach (config('app.locales-available') as $locale) {
            $translations[$locale] = $this->label($locale);
        }

        return $translations;
    }
}
