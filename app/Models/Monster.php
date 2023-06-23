<?php

namespace App\Models;

use App\Enum\MonsterCategory;
use Laravel\Scout\Searchable;
use App\Enum\MonsterExpansion;
use App\Models\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Monster extends Model
{
    use HasFactory;
    use HasTranslations;
    use Searchable;

    protected $fillable = [
        'name',
        'description',
        'category',
        'expansion',
    ];

    public array $translatable = [
        'name',
        'description',
    ];

    protected $casts = [
        'category' => MonsterCategory::class,
        'expansion' => MonsterExpansion::class,
    ];

    public function toSearchableArray(): array
    {
        $searchable = [
            'category' => $this->category->name,
            'expansion' => $this->expansion->name,
            'url' => route('wiki.monster.show', $this->id),
        ];
        foreach (config('app.locales-available') as $locale) {
            $searchable[$locale.'.name'] = $this->getTranslation('name', $locale);
        }

        return $searchable;
    }
}
