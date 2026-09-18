<?php

namespace App\Models;

use App\Models\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MonsterPart extends Model
{
    use HasFactory;
    use HasTranslations;

    protected $fillable = [
        'monster_difficulty_id',
        'icon',
        'direction',
        'defense',
        'broken',
        'ability_broken',
        'position',
    ];

    public array $translatable = [
        'ability_broken',
    ];

    public function difficulty(): BelongsTo
    {
        return $this->belongsTo(MonsterDifficulty::class, 'monster_difficulty_id');
    }
}
