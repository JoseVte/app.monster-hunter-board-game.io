<?php

namespace App\Models;

use App\Enum\DeviationWeapon;
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

        'rarity',
        'defense',
        'count_attack_1',
        'count_attack_2',
        'count_attack_3',
        'count_attack_4',
        'count_attack_5',
        'has_elemental_attacks',
        'element',
        'status_attacks',
        'deviation',
        'song_list_id',

        'type_id',
        'parent_id',
    ];

    protected $casts = [
        'has_elemental_attacks' => 'boolean',
        'is_default' => 'boolean',
        'deviation' => DeviationWeapon::class,
        // Plain lowercase keys, not a translatable enum: they reach a page to
        // pick an icon by name, and `HasTranslations::toArray()` would flatten
        // an enum cast to its label, which is not what `fire_icon` is keyed on.
        'status_attacks' => 'array',
    ];

    protected $with = [
        'type',
    ];

    /**
     * `HasTranslations::toArray()` flattens a translatable enum cast to its
     * label, so `deviation` reaches a page as "Baja" rather than as LOW. The
     * label is what a reader wants; the case is what picks the icon, which is
     * the same drawing in a colour per rating.
     */
    protected $appends = ['deviation_key'];

    public function getDeviationKeyAttribute(): ?string
    {
        return $this->deviation?->name;
    }

    public array $translatable = [
        'name',
    ];

    public function type(): BelongsTo
    {
        return $this->belongsTo(WeaponType::class, 'type_id');
    }

    public function songList(): BelongsTo
    {
        return $this->belongsTo(SongList::class);
    }

    public function parent(): HasOne
    {
        return $this->hasOne(__CLASS__, 'id', 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(__CLASS__, 'parent_id');
    }

    public function recipes(): HasMany
    {
        return $this->hasMany(WeaponRecipe::class)->orderBy('position');
    }

    public function items(): BelongsToMany
    {
        return $this->belongsToMany(Item::class, 'count_item_weapon')
            ->withPivot(['number'])
            ->withTimestamps()
            ->using(CountItemWeapon::class);
    }

    public function attacksToAdd(): BelongsToMany
    {
        return $this->belongsToMany(WeaponAttack::class, 'count_weapon_attack_add')
            ->withPivot(['number'])
            ->withTimestamps()
            ->using(CountWeaponAttackAdd::class);
    }

    public function attacksToRemove(): BelongsToMany
    {
        return $this->belongsToMany(WeaponAttack::class, 'count_weapon_attack_remove')
            ->withPivot(['number'])
            ->withTimestamps()
            ->using(CountWeaponAttackRemove::class);
    }

    public function toSearchableArray(): array
    {
        $searchable = [
            'url' => route('wiki.weapon.show', $this->id),
        ];
        foreach (config('app.locales-available') as $locale) {
            $searchable[$locale.'.name'] = $this->getTranslation('name', $locale);
            $searchable[$locale.'.type'] = $this->type->getTranslation('name', $locale);
        }

        return $searchable;
    }
}
