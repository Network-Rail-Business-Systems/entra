<?php

namespace NetworkRailBusinessSystems\Entra\Models;

use Illuminate\Contracts\Support\Arrayable;

class EntraUser implements Arrayable
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

    public function toArray(): array
    {
        return [
            'displayName' => $this->displayName,
            'givenName' => $this->givenName,
            'id' => $this->id,
            'jobTitle' => $this->jobTitle,
            'mail' => $this->mail,
            'officeLocation' => $this->officeLocation,
            'phone' => $this->phone,
            'surname' => $this->surname,
            'userPrincipalName' => $this->userPrincipalName,
        ];
    }
}
