<?php

namespace NetworkRailBusinessSystems\Entra\Models;

use NetworkRailBusinessSystems\Entra\EntraAuthenticatable;
use NetworkRailBusinessSystems\Entra\MsGraph;

class EntraUser
{
    public static function emulate(): void
    {
        // TODO
    }

    public static function find(
        string $term,
        string $field = 'mail',
        ?array $select = null,
    ): ?array {
        $parameters = http_build_query([
            '$filter' => "$field eq '$term'",
            '$select' => self::formatSelect($select),
            '$top' => 1,
        ]);

        $results = MsGraph::get("users?$parameters");

        return $results['value'][0] ?? null;
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

        $results = MsGraph::get("users?$parameters");

        return $results['value'] ?? [];
    }

    public static function import(
        string $term,
        string $field = 'mail',
        ?array $select = null,
    ): ?EntraAuthenticatable {
        $details = self::find($term, $field, $select);

        if ($details === null) {
            return null;
        }

        /** @var class-string<EntraAuthenticatable> $modelClass */
        $modelClass = config('entra.user_model');
        $user = $modelClass::getEntraModel($details);
        $user->syncEntraDetails($details);

        return $user;
    }

    protected static function formatSelect(?array $select): array
    {
        return $select === null
            ? config('entra.sync_attributes') ?? []
            : $select;
    }
}
