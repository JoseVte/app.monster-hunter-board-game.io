<?php

namespace App\Enum;

enum InvitationStatus: string
{
    case PENDING = 'pending';
    case ACCEPTED = 'accepted';
    case REVOKED = 'revoked';
    case EXPIRED = 'expired';
}
