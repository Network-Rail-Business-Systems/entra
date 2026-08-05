<?php

namespace NetworkRailBusinessSystems\Entra;

class EntraAccessToken
{
    public function __construct(
        public string $accessToken,
        public int $expiresIn,
        public string $refreshToken,
        public string $scope,
        public string $tokenType,
        public int $extExpiresIn,
    ) {
        //
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
}
