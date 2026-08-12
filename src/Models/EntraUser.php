<?php

namespace NetworkRailBusinessSystems\Entra\Models;

use Illuminate\Contracts\Support\Arrayable;
use NetworkRailBusinessSystems\Entra\Entra;

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
        public string $jobTitle = '',
        public string $officeLocation = '',
        public string $department = '',
        public int $employeeId = 0,
        array $businessPhones = [],
        string $mobilePhone = '',
    ) {
        $this->mail = strtolower($mail);
        $this->phone = $businessPhones[0] ?? $mobilePhone;
    }

    public static function make(array $details): EntraUser
    {
        return new EntraUser(
            $details['id'],
            $details['userPrincipalName'],
            $details['mail'],
            $details['displayName'],
            $details['givenName'],
            $details['surname'],
            $details['jobTitle'] ?? '',
            $details['officeLocation'] ?? '',
            $details['department'] ?? '',
            (int) ($details['employeeId'] ?? 0),
            $details['businessPhones'] ?? [],
            $details['mobilePhone'] ?? '',
        );
    }

    public function toArray(): array
    {
        return [
            'department' => $this->department,
            'displayName' => $this->displayName,
            'employeeId' => $this->employeeId,
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

    // Endpoints
    public static function count(
        EntraAccessToken $token,
        string $filter = '',
    ): int {
        $response = Entra::query(
            Entra::entraUserRoute() . '/$count',
            $token,
            $filter,
            headers: [
                'ConsistencyLevel' => 'eventual',
            ],
            acceptJson: false,
        );

        return (int) $response;
    }

    public static function get(
        EntraAccessToken $token,
        string $term,
        string $field,
        array $select = [],
    ): ?EntraUser {
        $response = Entra::query(
            Entra::entraUserRoute(),
            $token,
            "$field eq $term",
            $select,
            1,
        );

        return empty($response['value']) === false
            ? EntraUser::make($response['value'][0])
            : null;
    }

    /** @returns EntraUser[] */
    public static function list(
        EntraAccessToken $token,
        string $filter = '',
        array $select = [],
        int $per = 999,
        array $headers = [],
    ): EntraList {
        $response = Entra::query(
            Entra::entraUserRoute(),
            $token,
            $filter,
            $select,
            $per,
            $headers,
        );

        return EntraList::make(
            EntraUser::class,
            $token,
            $response,
        );
    }

    public static function me(EntraAccessToken $token): EntraUser
    {
        return EntraUser::make(
            Entra::query(
                Entra::entraMeRoute(),
                $token,
            ),
        );
    }
}
