<?php

namespace NetworkRailBusinessSystems\Entra\Interfaces;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use NetworkRailBusinessSystems\Entra\Models\EntraToken;

/**
 * @property ?EntraToken $entraToken
 */
interface EntraAuthenticatable extends Authenticatable
{
    // Relationships
    public function entraToken(): HasOne;

    // Utilities
    public function hasRefreshToken(): bool;

    public function hasValidAccessToken(): bool;

    public function needsToReauthenticate(): bool;

    public function refreshToken(): bool;
}

// TODO Detect whether user is guest and use generic account if so
