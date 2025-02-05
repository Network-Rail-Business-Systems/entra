<?php

namespace NetworkRailBusinessSystems\Entra\Tests\Data;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use NetworkRailBusinessSystems\Entra\AuthenticatesWithEntra;
use NetworkRailBusinessSystems\Entra\EntraAuthenticatable;

class User extends Model implements EntraAuthenticatable
{
    use Authenticatable;
    use AuthenticatesWithEntra;
}
