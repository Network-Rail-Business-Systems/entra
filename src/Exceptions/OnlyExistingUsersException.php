<?php

namespace NetworkRailBusinessSystems\Entra\Exceptions;

use ErrorException;

class OnlyExistingUsersException extends ErrorException
{
    public function __construct()
    {
        parent::__construct('only_existing', 0, E_NOTICE);
    }
}
