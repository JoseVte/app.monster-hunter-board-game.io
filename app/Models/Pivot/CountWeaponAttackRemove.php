<?php

namespace App\Models\Pivot;

use Illuminate\Database\Eloquent\Relations\Pivot;

class CountWeaponAttackRemove extends Pivot
{
    protected $fillable = [
        'number',
    ];
}
