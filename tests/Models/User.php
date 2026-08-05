<?php

namespace NetworkRailBusinessSystems\Entra\Tests\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use NetworkRailBusinessSystems\Entra\AuthenticatesWithEntra;

class User extends Model implements AuthenticatesWithEntra
{
    use Authenticatable;

    public static function findOrCreateByAzureId(string $azureId): AuthenticatesWithEntra
    {
        return new User();
    }
}
