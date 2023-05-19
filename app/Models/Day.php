<?php

namespace App\Models;

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
        'hunted',

        'campaign_id',
        'monster_id',
    ];

    protected $casts = [
        'hunted' => 'boolean',
    ];

    public function campaign(): BelongsTo
    {
        return $this->belongsTo(Campaign::class);
    }

    public function monster(): HasOne
    {
        return $this->hasOne(Monster::class);
    }

    public function hunters(): BelongsToMany
    {
        return $this->belongsToMany(Hunter::class)->using(DayDowntimeActivityHunter::class);
    }
}
