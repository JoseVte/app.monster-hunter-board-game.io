<?php

namespace App\Models\Pivot;

use Illuminate\Database\Eloquent\Relations\Pivot;

class CountItemHunter extends Pivot
{
    protected $table = 'count_item_hunter';

    protected $fillable = [
        'number',
    ];
}
