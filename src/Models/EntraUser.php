<?php

namespace NetworkRailBusinessSystems\Entra\Models;

use Illuminate\Support\Facades\Auth;
use NetworkRailBusinessSystems\Entra\EntraAuthenticatable;
use NetworkRailBusinessSystems\Entra\Facades\MsGraph;
use NetworkRailBusinessSystems\Entra\Facades\MsGraphAdmin;

class EntraUser extends EntraModel
{
    public static function get(
        string $term,
        string $field = 'mail',
        ?array $select = null,
    ): ?array {
        $parameters = http_build_query([
            '$filter' => "$field eq '$term'",
            '$select' => self::formatSelect($select),
            '$top' => 1,
        ]);

        $results = match (true) {
            self::emulatorIsEnabled() => self::emulateGet($term, $field),
            Auth::check() => MsGraph::get("users?$parameters"),
            default => MsGraphAdmin::get("users?$parameters"),
        };

        return is_array($results) === true
            ? $results['value'][0] ?? null
            : null;
    }

    public static function list(
        string $term,
        string $field = 'mail',
        int $limit = 10,
        ?array $select = null,
    ): array {
        $parameters = http_build_query([
            '$filter' => "startsWith($field, '$term')",
            '$select' => self::formatSelect($select),
            '$top' => $limit,
        ]);

        $results = match (true) {
            self::emulatorIsEnabled() => self::emulateList($term, $field),
            Auth::check() => MsGraph::get("users?$parameters"),
            default => MsGraphAdmin::get("users?$parameters"),
        };

        return is_array($results) === true
            ? $results['value'] ?? []
            : [];
    }

    public static function import(
        string $term,
        string $field = 'mail',
        ?array $select = null,
    ): ?EntraAuthenticatable {
        $details = self::get($term, $field, $select);

        if ($details === null) {
            return null;
        }

        /** @var class-string<EntraAuthenticatable> $modelClass */
        $modelClass = config('entra.user_model');
        $user = $modelClass::getEntraModel($details);
        $user->syncEntraDetails($details);

        return $user;
    }

    // Formatting
    protected static function formatSelect(?array $select): string
    {
        $select = $select === null
            ? array_keys(
                config('entra.sync_attributes') ?? [],
            )
            : $select;

        return implode(',', $select);
    }

    // Emulation
    public static function emulateResults(?array $results = null): array
    {
        if ($results === null) {
            $results = [self::emulatorExample()];
        } else {
            foreach ($results as $index => $result) {
                if (
                    array_key_exists('businessPhones', $result) === true
                    && is_array($result['businessPhones']) === false
                ) {
                    $results[$index]['businessPhones'] = [
                        $result['businessPhones'],
                    ];
                }
            }
        }

        return [
            '@odata.context' => 'https://graph.microsoft.com/v1.0/$metadata#users',
            '@odata.nextLink' => 'https://graph.microsoft.com/v1.0/users',
            'value' => $results,
        ];
    }

    protected static function emulatorExample(): array
    {
        return [
            'businessPhones' => [
                '01234567890',
            ],
            'displayName' => 'Joe Bloggs',
            'givenName' => 'Joe',
            'jobTitle' => 'Business Systems Developer',
            'mail' => 'Joe.Bloggs@networkrail.co.uk',
            'mobilePhone' => '01234567890',
            'officeLocation' => 'Some Office',
            'preferredLanguage' => null,
            'surname' => 'Bloggs',
            'userPrincipalName' => 'JBloggs2@networkrail.co.uk',
            'id' => '123ab4c5-6789-01de-f2g3-45678hijk9lm',
        ];
    }

    protected static function emulatorConfig(): array
    {
        return config('entra.emulator.users');
    }
}
