<?php

namespace App\Models\Pivot;

use Illuminate\Database\Eloquent\Relations\Pivot;

class HunterWeapon extends Pivot
{
    protected $fillable = ['equipped'];
}
