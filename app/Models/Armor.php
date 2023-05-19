<?php

namespace App\Models;

use App\Enum\ArmorType;
use Laravel\Scout\Searchable;
use App\Models\Pivot\CountItemArmor;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Pivot\ArmorAbility as ArmorAbilityPivot;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Armor extends Model
{
    use HasFactory;
    use HasTranslations;
    use Searchable;

    protected $fillable = [
        'type',
        'name',

        'is_default',

        'defense',
        'defense_fire',
        'defense_water',
        'defense_thunder',
        'defense_ice',
        'defense_dragon',
    ];

    protected $casts = [
        'type' => ArmorType::class,
        'is_default' => 'boolean',
    ];

    protected $with = [
        'abilities'
    ];

    public array $translatable = [
        'name',
    ];

    public function abilities(): BelongsToMany
    {
        return $this->belongsToMany(ArmorAbility::class, 'armor_ability')->using(ArmorAbilityPivot::class);
    }

    public function items(): BelongsToMany
    {
        return $this->belongsToMany(Item::class, 'count_item_armor')->using(CountItemArmor::class);
    }

    public function toSearchableArray(): array
    {
        $searchable = [
            'url' => 'TODO',
        ];
        foreach ($this->type->getTranslations() as $locale => $translation) {
            $searchable[$locale.'.type'] = $translation;
            $searchable[$locale.'.name'] = $this->getTranslation('name', $locale);
            foreach ($this->abilities as $index => $ability) {
                $searchable[$locale.'.'.$index.'.ability'] = $ability->getTranslation('name', $locale);
            }
        }

        return $searchable;
    }
}
