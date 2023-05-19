<?php

namespace App\Models\Pivot;

use Illuminate\Database\Eloquent\Relations\Pivot;

class CountItemHunter extends Pivot
{
    protected $fillable = [
        'number',
    ];
}
