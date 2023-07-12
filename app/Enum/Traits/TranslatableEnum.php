<?php

namespace App\Enum\Traits;

use ValueError;
use App\Enum\Contracts\TranslatableEnum as TranslatableEnumContract;

trait TranslatableEnum
{
    public static function asSelectable(): array
    {
        return collect(self::cases())
            ->keyBy(fn (self $enum) => $enum->name)
            ->map(fn (self $enum) => $enum->label())
            ->toArray();
    }

    public static function asKeyLabelObjectSelectable(): array
    {
        return collect(self::cases())
            ->map(fn (self $enum) => [
                'key' => $enum->name,
                'label' => $enum->label(),
            ])
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

    public static function rule(): array
    {
        return collect(self::cases())
            ->map(fn (self $enum) => $enum->name)
            ->toArray();
    }

    public static function fromName(string $name): self
    {
        foreach (self::cases() as $status) {
            if ($name === $status->name) {
                return $status;
            }
        }
        throw new ValueError("$name is not a valid backing value for enum ".self::class);
    }

    public static function tryFromName(string $name): self|null
    {
        try {
            return self::fromName($name);
        } catch (ValueError $error) {
            return null;
        }
    }
}
