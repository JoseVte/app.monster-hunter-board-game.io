<?php

namespace App\Enum\Contracts;

interface TranslatableEnum
{
    public function label(string $locale = null): string;

    public static function asSelectable(): array;

    public function getTranslations(): array;
}
