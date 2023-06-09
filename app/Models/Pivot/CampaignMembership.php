<?php

namespace App\Models\Pivot;

use Spatie\Permission\Models\Role;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CampaignMembership extends Pivot
{
    protected $table = 'campaign_user';

    protected $with = ['role'];

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }
}
