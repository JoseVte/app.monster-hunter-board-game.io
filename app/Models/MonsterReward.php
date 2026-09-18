<?php

namespace App\Models;

use App\Models\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MonsterReward extends Model
{
    use HasFactory;
    use HasTranslations;

    protected $fillable = [
        'monster_id',
        'roll',
        'item_id',
        'extra',
    ];

    public array $translatable = [
        'extra',
    ];

    public function monster(): BelongsTo
    {
        return $this->belongsTo(Monster::class);
    }

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }
}
