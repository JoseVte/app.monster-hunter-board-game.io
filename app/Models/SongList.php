<?php

namespace App\Models;

use App\Models\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * One of the song list cards a hunting horn plays from, named on the horn's own
 * weapon card.
 */
class SongList extends Model
{
    use HasTranslations;

    protected $fillable = [
        'weapon_type_id',
        'name',
        'position',
    ];

    public array $translatable = [
        'name',
    ];

    public function weaponType(): BelongsTo
    {
        return $this->belongsTo(WeaponType::class);
    }

    public function songs(): HasMany
    {
        return $this->hasMany(Song::class)->orderBy('position');
    }

    public function weapons(): HasMany
    {
        return $this->hasMany(Weapon::class);
    }
}
