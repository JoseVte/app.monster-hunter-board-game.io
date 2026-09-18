<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Invitations
    |--------------------------------------------------------------------------
    |
    | Registration is invitation only. Every user may hold a number of pending
    | invitations at once; accepting, revoking or letting one expire frees a
    | slot. Sending is rate limited separately, see the `invitations` limiter.
    |
    */

    'expires_after_days' => (int) env('INVITATIONS_EXPIRE_DAYS', 7),

    'max_pending_per_user' => (int) env('INVITATIONS_MAX_PENDING', 10),

];
