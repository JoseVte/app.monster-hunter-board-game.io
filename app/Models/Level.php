<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Level extends Model
{
    protected $guarded = [];

    public function experiences(): HasMany
    {
        return $this->hasMany(Experience::class);
    }

    protected function casts(): array
    {
        return [
            'level' => 'integer',
            'next_level_experience' => 'integer',
        ];
    }
}
