<?php

namespace NetworkRailBusinessSystems\Entra\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use NetworkRailBusinessSystems\Entra\Interfaces\EntraAuthenticatable;
use NetworkRailBusinessSystems\Entra\Models\EntraToken;

/**
 * @mixin EntraAuthenticatable
 * @mixin Model
 */
trait AuthenticatesWithEntra
{
    // Relationships
    public function entraToken(): HasOne
    {
        return $this->hasOne(EntraToken::class);
    }

    // Utilities
    public function hasRefreshToken(): bool
    {
        return $this->entraToken !== null
            && $this->entraToken->refresh_token !== null;
    }

    public function hasValidAccessToken(): bool
    {
        return $this->entraToken !== null
            && $this->entraToken->hasExpired() === false;
    }

    public function needsToReauthenticate(): bool
    {
        return $this->hasValidAccessToken() === false
            || $this->hasRefreshToken() === false
            || $this->refreshToken() === false;
    }

    public function refreshToken(): bool
    {
        // TODO Attempt to redeem refresh token
        // Capture specific errors?
    }
}
