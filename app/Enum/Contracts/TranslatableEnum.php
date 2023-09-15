<?php

namespace App\Enum\Contracts;

interface TranslatableEnum
{
    public function label(string $locale = null): string;

    public static function asSelectable(): array;

    public static function asKeyLabelObjectSelectable(): array;

    public function getTranslations(): array;

    public static function rule(): array;

    public static function fromName(string $name): self;

    public static function tryFromName(string $name): ?self;
}
