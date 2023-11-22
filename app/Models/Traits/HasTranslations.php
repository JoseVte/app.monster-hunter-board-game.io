<?php

namespace App\Models\Traits;

use DB;
use App\Enum\Traits\TranslatableEnum;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Translatable\HasTranslations as BaseHasTranslations;

trait HasTranslations
{
    use BaseHasTranslations;

    public function scopeSearchTranslate(Builder $builder, string $field, string $value, string $locale = null): Builder
    {
        $locale = $locale ?: app()->getLocale();

        return $builder->where(
            DB::raw('lower(JSON_EXTRACT('.$field.', \'$.'.$locale.'\'))'),
            'like',
            '%'.strtolower($value).'%'
        );
    }

    public function toArray(): array
    {
        $attributes = parent::toArray();
        $locale = app()->getLocale();
        foreach ($this->getTranslatableAttributes() as $field) {
            $attributes[$field] = $this->getTranslation($field, $locale);
        }
        foreach ($this->casts as $field => $cast) {
            if (!empty($this->getAttribute($field)) && class_exists($cast) && in_array(TranslatableEnum::class, class_uses_recursive($cast), true)) {
                $attributes[$field] = $this->getAttribute($field)->label($locale);
            }
        }

        return $attributes;
    }
}
