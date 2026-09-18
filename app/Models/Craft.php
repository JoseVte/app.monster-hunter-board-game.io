<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * One act of crafting. Kept because an upgrade replaces the equipment it was
 * made from, so what a hunter owns is not what they have made.
 */
class Craft extends Model
{
    protected $fillable = [
        'user_id',
        'craftable_type',
        'craftable_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function craftable(): MorphTo
    {
        return $this->morphTo();
    }
}
