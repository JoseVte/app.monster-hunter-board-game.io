<?php

namespace App\Models\Pivot;

use Illuminate\Database\Eloquent\Relations\Pivot;

class CountItemWeapon extends Pivot
{
    /**
     * `weapon_id` is redundant with the recipe that owns the row, but keeping it
     * lets `Weapon::items()` stay a plain relation over every material a weapon
     * can need, rather than a two hop join through its recipes.
     */
    protected $fillable = [
        'number',
        'weapon_id',
    ];
}
