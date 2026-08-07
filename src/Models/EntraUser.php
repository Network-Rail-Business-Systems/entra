<?php

namespace NetworkRailBusinessSystems\Entra\Models;

class EntraUser
{
    public string $phone = '';

    public function __construct(
        public string $id,
        public string $userPrincipalName,
        public string $mail,
        public string $displayName,
        public string $givenName,
        public string $surname,
        public string $jobTitle,
        public string $officeLocation,
        array $businessPhones,
        string $mobilePhone,
    ) {
        $this->phone = $businessPhones[0] ?? $mobilePhone;
    }
}
