<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Campaign extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'max_days',
        'health_potions',

        'team_id',
    ];

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function hunters(): HasMany
    {
        return $this->hasMany(Hunter::class, 'campaign_id');
    }

    public function days(): HasMany
    {
        return $this->hasMany(Day::class, 'campaign_id');
    }
}
