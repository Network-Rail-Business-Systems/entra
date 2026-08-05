<?php

namespace NetworkRailBusinessSystems\Entra;

use Illuminate\Contracts\Auth\Authenticatable;

interface AuthenticatesWithEntra extends Authenticatable
{
    public static function findOrCreateByAzureId(string $azureId): static;
}
