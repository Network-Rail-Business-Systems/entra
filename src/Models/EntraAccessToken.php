<?php

namespace NetworkRailBusinessSystems\Entra\Models;

use Carbon\Carbon;
use NetworkRailBusinessSystems\Entra\Entra;

class EntraAccessToken
{
    public Carbon $expires_at;

    public function __construct(
        public string $accessToken,
        public int $expiresIn,
        public string $refreshToken,
        public string $scope,
        public string $tokenType,
        public int $extExpiresIn,
    ) {
        $this->expires_at = Carbon::now()->addSeconds($this->expiresIn);
    }

    public static function fake(): EntraAccessToken
    {
        return new EntraAccessToken(
            'abc123',
            1234,
            'def456',
            'scopes',
            'Bearer',
            1234,
        );
    }

    public function hasExpired(): bool
    {
        return $this->expires_at->isPast() === true;
    }

    public function refresh(): EntraAccessToken
    {
        return Entra::refreshToken($this);
    }
}
