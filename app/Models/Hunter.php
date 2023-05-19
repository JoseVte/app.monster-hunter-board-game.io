<?php

namespace App\Models;

use App\Models\Pivot\HunterArmor;
use App\Models\Pivot\HunterWeapon;
use App\Models\Pivot\CountItemHunter;
use Illuminate\Database\Eloquent\Model;
use App\Models\Pivot\DayDowntimeActivityHunter;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Hunter extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',

        'campaign_id',
    ];

    public function campaign(): BelongsTo
    {
        return $this->belongsTo(Campaign::class);
    }

    public function palico(): HasOne
    {
        return $this->hasOne(Palico::class, 'hunter_id');
    }

    public function days(): BelongsToMany
    {
        return $this->belongsToMany(Day::class)->using(DayDowntimeActivityHunter::class);
    }

    public function items(): BelongsToMany
    {
        return $this->belongsToMany(Item::class)->using(CountItemHunter::class);
    }

    public function weapons(): BelongsToMany
    {
        return $this->belongsToMany(Weapon::class)->using(HunterWeapon::class);
    }

    public function armors(): BelongsToMany
    {
        return $this->belongsToMany(Armor::class)->using(HunterArmor::class);
    }
}
