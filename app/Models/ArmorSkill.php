<?php

namespace App\Models;

use Laravel\Scout\Searchable;
use App\Models\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ArmorSkill extends Model
{
    use HasFactory;
    use HasTranslations;
    use Searchable;

    protected $fillable = [
        'name',
        'description',

        'bonus_set',
        'bonus_set_armor',
    ];

    protected $casts = [
        'bonus_set' => 'boolean',
        'bonus_set_armor' => 'array',
    ];

    public array $translatable = [
        'name',
        'description',
    ];

    public function toSearchableArray(): array
    {
        $searchable = [
            'url' => 'TODO',
        ];
        foreach (config('app.locales-available') as $locale) {
            $searchable[$locale.'.name'] = $this->getTranslation('name', $locale);
        }

        return $searchable;
    }
}
