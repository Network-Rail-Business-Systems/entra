<?php

namespace NetworkRailBusinessSystems\Entra;

class Entra
{
    public static function emulate(): void
    {
        // TODO
    }

    public static function findGroup(string $term, string $field = 'mail'): ?array
    {
        // TODO
        return [];
    }

    public static function findGroups(string $term, string $field = 'mail'): ?array
    {
        // TODO
        return [];
    }

    public static function findUser(string $term, string $field = 'mail'): ?array
    {
        // TODO
        return [];
    }

    public static function findUsers(string $term, string $field = 'mail'): ?array
    {
        // TODO
        return [];
    }

    public static function importUser(string $term, string $field = 'mail'): EntraAuthenticatable
    {
        // TODO

        /** @var class-string<EntraAuthenticatable> $modelClass */
        $modelClass = config('entra.user_model');
        return new $modelClass();
    }
}
