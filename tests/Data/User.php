<?php

namespace NetworkRailBusinessSystems\Entra\Tests\Data;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use NetworkRailBusinessSystems\Entra\AuthenticatesWithEntra;
use NetworkRailBusinessSystems\Entra\EntraAuthenticatable;
use NetworkRailBusinessSystems\Entra\Tests\Database\Factories\UserFactory;

/**
 * @property string $azure_id
 * @property string $business_phone
 * @property string $email
 * @property string $first_name
 * @property string $id
 * @property string $last_name
 * @property string $name
 * @property string $office
 * @property string $mobile_phone
 * @property string $title
 * @property string $username
 */
class User extends Model implements EntraAuthenticatable
{
    use Authenticatable;
    use AuthenticatesWithEntra;
    use HasFactory;

    protected static function newFactory(): UserFactory
    {
        return new UserFactory();
    }
}
