<?php

namespace App\Models;

use App\Models\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Enum\MonsterDifficulty as MonsterDifficultyEnum;

class MonsterDifficulty extends Model
{
    use HasFactory;
    use HasTranslations;

    protected $fillable = [
        'monster_id',
        'difficulty',
        'stars',
        'health',
        'ability_name',
        'ability_description',
    ];

    protected $casts = [
        'difficulty' => MonsterDifficultyEnum::class,
    ];

    public array $translatable = [
        'ability_name',
        'ability_description',
    ];

    public function monster(): BelongsTo
    {
        return $this->belongsTo(Monster::class);
    }

    public function parts(): HasMany
    {
        return $this->hasMany(MonsterPart::class)->orderBy('position');
    }
}
