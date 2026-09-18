<?php

namespace App\Models;

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
        'position',
    ];

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
