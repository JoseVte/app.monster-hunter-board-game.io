<?php

namespace App\Models\Pivot;

use App\Models\DowntimeActivity;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Relations\HasOne;

class DayDowntimeActivityHunter extends Pivot
{
    public function downtimeActivity(): HasOne
    {
        return $this->hasOne(DowntimeActivity::class, 'id', 'downtime_activity_id');
    }
}
