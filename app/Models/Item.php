<?php

namespace App\Models;

use App\Enum\ItemType;
use Laravel\Scout\Searchable;
use App\Models\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Item extends Model
{
    use HasFactory;
    use HasTranslations;
    use Searchable;

    protected $fillable = [
        'type',
        'name',
    ];

    protected $casts = [
        'type' => ItemType::class,
    ];

    public array $translatable = [
        'name',
    ];

    public function toSearchableArray(): array
    {
        $searchable = [
            'url' => route('wiki.item.show', $this->id),
        ];
        foreach ($this->type->getTranslations() as $locale => $translation) {
            $searchable[$locale.'.type'] = $translation;
            $searchable[$locale.'.name'] = $this->getTranslation('name', $locale);
        }

        return $searchable;
    }
}
