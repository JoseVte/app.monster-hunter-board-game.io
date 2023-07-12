<?php

namespace App\Models;

use App\Enum\MonsterDifficulty;
use Illuminate\Database\Eloquent\Model;
use App\Models\Pivot\DayDowntimeActivityHunter;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Day extends Model
{
    use HasFactory;

    protected $fillable = [
        'number',
        'difficulty',
        'hunted',

        'campaign_id',
        'monster_id',
        'downtime_activity_id',
    ];

    protected $casts = [
        'difficulty' => MonsterDifficulty::class,
        'hunted' => 'boolean',
        'all_hunters_same_activity' => 'boolean',
    ];

    public function campaign(): BelongsTo
    {
        return $this->belongsTo(Campaign::class);
    }

    public function monster(): HasOne
    {
        return $this->hasOne(Monster::class, 'id', 'monster_id');
    }

    public function downtimeActivity(): HasOne
    {
        return $this->hasOne(DowntimeActivity::class, 'id', 'downtime_activity_id');
    }

    public function hunters(): BelongsToMany
    {
        return $this->belongsToMany(Hunter::class, DayDowntimeActivityHunter::class)
            ->withPivot('downtime_activity_id')
            ->withTimestamps()
            ->using(DayDowntimeActivityHunter::class);
    }
}
