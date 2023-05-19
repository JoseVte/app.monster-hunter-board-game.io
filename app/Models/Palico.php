<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Palico extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',

        'hunter_id',
    ];

    public function hunter(): BelongsTo
    {
        return $this->belongsTo(Hunter::class);
    }
}
