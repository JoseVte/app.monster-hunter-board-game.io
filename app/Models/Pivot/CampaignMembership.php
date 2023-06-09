<?php

namespace App\Models\Pivot;

use App\Models\Hunter;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CampaignMembership extends Pivot
{
    protected $table = 'campaign_user';

    protected $with = ['role', 'hunter'];

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function hunter(): HasOne
    {
        return $this->hasOne(Hunter::class, 'id', 'hunter_id');
    }
}
