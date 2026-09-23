<?php

namespace App\Models;

use App\Models\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * What a song does once it is played. The catalogue is shared: several lists
 * call on the same effect, so it is named once rather than per list.
 */
class SongEffect extends Model
{
    use HasTranslations;

    protected $fillable = [
        'name',
        'description',
    ];

    public array $translatable = [
        'name',
        'description',
    ];

    public function songs(): HasMany
    {
        return $this->hasMany(Song::class);
    }
}
