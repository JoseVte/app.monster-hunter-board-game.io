<?php

namespace App\Exceptions;

use Exception;

class InvitationNoLongerPendingException extends Exception
{
    public function __construct()
    {
        parent::__construct(__('This invitation is no longer valid.'));
    }
}
