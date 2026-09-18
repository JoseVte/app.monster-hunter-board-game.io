<?php

namespace App\Models\Traits;

use DB;
use App\Enum\Traits\TranslatableEnum;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Translatable\HasTranslations as BaseHasTranslations;

trait HasTranslations
{
    use BaseHasTranslations;

    public function scopeSearchTranslate(Builder $builder, string $field, string $value, ?string $locale = null): Builder
    {
        $locale = $locale ?: app()->getLocale();

        return $builder->where(
            DB::raw('lower(JSON_EXTRACT('.$field.', \'$.'.$locale.'\'))'),
            'like',
            '%'.strtolower($value).'%'
        );
    }

    /**
     * A name in any language the app carries. The wiki is read in one locale but
     * the pieces are as often known by the other, so a search that only looked
     * at the current one would miss half of what a player types.
     *
     * json_extract rather than the `->` operator: on MySQL the extracted value
     * keeps a binary collation and compares case sensitively, so it is lowered
     * on both sides. Both MySQL and sqlite carry the function, so this one is
     * covered by the suite where scopeSearchTranslate could not be.
     */
    public function scopeWhereNameLike(Builder $builder, ?string $value): Builder
    {
        if (blank($value)) {
            return $builder;
        }

        $term = '%'.mb_strtolower(trim($value)).'%';

        return $builder->where(function (Builder $query) use ($term): void {
            foreach (config('app.locales-available') as $locale) {
                $query->orWhere(DB::raw("lower(json_extract(name, '$.".$locale."'))"), 'like', $term);
            }
        });
    }

    public function toArray(): array
    {
        $attributes = parent::toArray();
        $locale = app()->getLocale();
        foreach ($this->getTranslatableAttributes() as $field) {
            $attributes[$field] = $this->getTranslation($field, $locale);
        }
        foreach ($this->casts as $field => $cast) {
            if (! empty($this->getAttribute($field)) && class_exists($cast) && in_array(TranslatableEnum::class, class_uses_recursive($cast), true)) {
                $attributes[$field] = $this->getAttribute($field)->label($locale);
            }
        }

        return $attributes;
    }
}
