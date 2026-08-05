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
}
