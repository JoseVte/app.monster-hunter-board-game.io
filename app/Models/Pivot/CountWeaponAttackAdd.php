<?php

namespace App\Models\Pivot;

use Illuminate\Database\Eloquent\Relations\Pivot;

class CountWeaponAttackAdd extends Pivot
{
    protected $fillable = [
        'number',
    ];
}
