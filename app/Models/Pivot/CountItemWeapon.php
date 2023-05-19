<?php

namespace App\Models\Pivot;

use Illuminate\Database\Eloquent\Relations\Pivot;

class CountItemWeapon extends Pivot
{
    protected $fillable = [
        'number',
    ];
}
