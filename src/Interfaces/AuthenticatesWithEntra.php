<?php

namespace NetworkRailBusinessSystems\Entra\Interfaces;

use Illuminate\Contracts\Auth\Authenticatable;

interface AuthenticatesWithEntra extends Authenticatable
{
    public static function findOrCreateByAzureId(string $azureId): AuthenticatesWithEntra;
}
