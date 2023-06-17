<?php

namespace App\Models;

use Laravel\Scout\Searchable;
use App\Models\Pivot\CountItemWeapon;
use App\Models\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;
use App\Models\Pivot\CountWeaponAttackAdd;
use App\Models\Pivot\CountWeaponAttackRemove;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Weapon extends Model
{
    use HasFactory;
    use HasTranslations;
    use Searchable;

    protected $fillable = [
        'name',

        'is_default',
        'branch_id',
        'branch',

        'rarity',
        'defense',
        'count_attack_1',
        'count_attack_2',
        'count_attack_3',
        'count_attack_4',
        'count_attack_5',
        'has_elemental_attacks',

        'type_id',
        'parent_id',
    ];

    protected $casts = [
        'has_elemental_attacks' => 'boolean',
        'is_default' => 'boolean',
    ];

    protected $with = [
        'type',
    ];

    public array $translatable = [
        'name',
    ];

    public function type(): BelongsTo
    {
        return $this->belongsTo(WeaponType::class, 'type_id');
    }

    public function parent(): HasOne
    {
        return $this->hasOne(__CLASS__, 'id', 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(__CLASS__, 'parent_id');
    }

    public function items(): BelongsToMany
    {
        return $this->belongsToMany(Item::class, 'count_item_weapon')->using(CountItemWeapon::class);
    }

    public function attacksToAdd(): BelongsToMany
    {
        return $this->belongsToMany(WeaponAttack::class, 'count_weapon_attack_add')->using(CountWeaponAttackAdd::class);
    }

    public function attacksToRemove(): BelongsToMany
    {
        return $this->belongsToMany(WeaponAttack::class, 'count_weapon_attack_remove')->using(CountWeaponAttackRemove::class);
    }

    public function toSearchableArray(): array
    {
        $searchable = [
            'url' => 'TODO',
        ];
        foreach (config('app.locales-available') as $locale) {
            $searchable[$locale.'.name'] = $this->getTranslation('name', $locale);
            $searchable[$locale.'.type'] = $this->type->getTranslation('name', $locale);
        }

        return $searchable;
    }
}
