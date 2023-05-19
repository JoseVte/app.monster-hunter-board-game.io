<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
use App\Models\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WeaponType extends Model
{
    use HasFactory;
    use HasTranslations;
    use Searchable;

    protected $fillable = [
        'name',
        'description',
    ];

    public array $translatable = [
        'name',
        'description',
    ];

    public function weapons(): HasMany
    {
        return $this->hasMany(Weapon::class, 'type_id');
    }

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
