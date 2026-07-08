<?php

namespace NetworkRailBusinessSystems\Entra\Exceptions;

use ErrorException;

class EmailMissingException extends ErrorException
{
    public function __construct()
    {
        parent::__construct('email_missing', 0, E_NOTICE);
    }
}
