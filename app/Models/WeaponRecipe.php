<?php

namespace App\Models;

use App\Enum\MonsterExpansion;
use App\Models\Pivot\CountItemWeapon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * One way of making a weapon: the monster line it belongs to and what it costs.
 * Most weapons have exactly one.
 */
class WeaponRecipe extends Model
{
    protected $fillable = [
        'weapon_id',
        'branch',
        'branch_id',
        'expansion',
        'position',
    ];

    protected $casts = [
        'expansion' => MonsterExpansion::class,
    ];

    /**
     * The recipe has no translatable field of its own, so it does not carry the
     * trait that flattens a translatable enum for the frontend. Without this the
     * expansion reaches a page as KULU_YA_KU_EXPANSION rather than its name.
     */
    protected $appends = ['expansion_label'];

    public function getExpansionLabelAttribute(): ?string
    {
        return $this->expansion?->label();
    }

    public function weapon(): BelongsTo
    {
        return $this->belongsTo(Weapon::class);
    }

    public function monster(): BelongsTo
    {
        return $this->belongsTo(Monster::class, 'branch_id');
    }

    public function items(): BelongsToMany
    {
        return $this->belongsToMany(Item::class, 'count_item_weapon')
            ->withPivot(['number'])
            ->withTimestamps()
            ->using(CountItemWeapon::class);
    }

    protected function casts(): array
    {
        return [
            'position' => 'integer',
        ];
    }
}
