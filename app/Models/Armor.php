<?php

namespace App\Models;

use App\Enum\ArmorType;
use Laravel\Scout\Searchable;
use App\Models\Pivot\CountItemArmor;
use App\Models\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;
use App\Models\Pivot\ArmorSkill as ArmorSkillPivot;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use AjCastro\EagerLoadPivotRelations\EagerLoadPivotTrait;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Armor extends Model
{
    use HasFactory;
    use HasTranslations;
    use Searchable;
    use EagerLoadPivotTrait;

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
        'skills',
    ];

    public array $translatable = [
        'name',
    ];

    public function skills(): BelongsToMany
    {
        return $this->belongsToMany(ArmorSkill::class, 'armor_skill')
            ->withTimestamps()
            ->using(ArmorSkillPivot::class);
    }

    public function items(): BelongsToMany
    {
        return $this->belongsToMany(Item::class, 'count_item_armor')->using(CountItemArmor::class);
    }

    public function toSearchableArray(): array
    {
        $searchable = [
            'url' => route('wiki.armor.show', $this->id),
            'type' => strtolower($this->type->name),
        ];
        foreach ($this->type->getTranslations() as $locale => $translation) {
            $searchable[$locale.'.type'] = $translation;
            $searchable[$locale.'.name'] = $this->getTranslation('name', $locale);
            foreach ($this->skills as $index => $skill) {
                $searchable[$locale.'.'.$index.'.skill'] = $skill->getTranslation('name', $locale);
            }
        }

        return $searchable;
    }
}
