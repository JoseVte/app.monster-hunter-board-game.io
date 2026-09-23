<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * One line of a song list: the effect it plays, the run of notes it is played
 * with and how far the effect reaches.
 */
class Song extends Model
{
    protected $fillable = [
        'song_list_id',
        'song_effect_id',
        'range',
        'notes',
        'position',
    ];

    protected $casts = [
        // Plain colour names, the way the data writes them and the way the page
        // looks their artwork up.
        'notes' => 'array',
        'range' => 'integer',
    ];

    protected $with = [
        'effect',
    ];

    public function list(): BelongsTo
    {
        return $this->belongsTo(SongList::class, 'song_list_id');
    }

    public function effect(): BelongsTo
    {
        return $this->belongsTo(SongEffect::class, 'song_effect_id');
    }
}
