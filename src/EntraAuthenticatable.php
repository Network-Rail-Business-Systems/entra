<?php

namespace NetworkRailBusinessSystems\Entra;

use Illuminate\Contracts\Auth\Authenticatable;

interface EntraAuthenticatable extends Authenticatable
{
    public static function getEntraModel(array $details): self;

    public function syncEntraDetails(array $details): self;

    public function entraId(): string;

    public function entraEmail(): string;
}
