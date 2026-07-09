<?php

namespace NetworkRailBusinessSystems\Entra\Models;

use Illuminate\Support\Str;

abstract class EntraModel
{
    // Formatting
    protected static function formatTerm(string $term): string
    {
        return Str::of($term)
            ->replace('\'', '\'\'')
            ->toString();
    }

    protected static function formatSelect(array $select): string
    {
        return implode(',', $select);
    }

    // Emulation
    abstract public static function emulateResults(?array $results = null): array;

    abstract protected static function emulatorExample(): array;

    abstract protected static function emulatorConfig(): array;

    protected static function emulatorIsEnabled(): bool
    {
        return config('entra.emulator.enabled') === true;
    }

    protected static function emulateGet(string $term, string $field): array
    {
        $users = static::emulatorConfig();
        $results = [];

        foreach ($users as $details) {
            if (
                array_key_exists($field, $details) === true
                && $details[$field] === $term
            ) {
                $results[] = $details;
                break;
            }
        }

        return static::emulateResults($results);
    }

    protected static function emulateList(string $term, string $field): array
    {
        $users = static::emulatorConfig();
        $results = [];

        foreach ($users as $details) {
            if (str_starts_with($details[$field], $term) === true) {
                $results[] = $details;
            }
        }

        return static::emulateResults($results);
    }
}
