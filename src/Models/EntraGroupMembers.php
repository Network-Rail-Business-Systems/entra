<?php

namespace NetworkRailBusinessSystems\Entra\Models;

use Illuminate\Support\Facades\Auth;
use NetworkRailBusinessSystems\Entra\Facades\MsGraph;
use NetworkRailBusinessSystems\Entra\Facades\MsGraphAdmin;

class EntraGroupMembers extends EntraModel
{
    public const string NEXT_LINK = '@odata.nextLink';

    public static function get(
        string $term,
        string $field = 'mail',
        array $select = ['mail'],
    ): ?array {
        $group = EntraGroup::get($term, $field, ['id']);

        if ($group === null) {
            return null;
        }

        $parameters = http_build_query([
            '$select' => self::formatSelect($select),
        ]);

        $id = $group['id'];
        $url = "groups/$id/members?$parameters";

        $results = match (true) {
            self::emulatorIsEnabled() => self::emulateGet($term, $field, true),
            Auth::check() => MsGraph::get($url),
            default => MsGraphAdmin::get($url),
        };

        $members = $results['value'];

        while (array_key_exists(self::NEXT_LINK, $results) === true) {
            $results = match (true) {
                self::emulatorIsEnabled() => self::emulateGet($term, $field),
                Auth::check() => MsGraph::get($results[self::NEXT_LINK]),
                default => MsGraphAdmin::get($results[self::NEXT_LINK]),
            };

            $members = array_merge(
                $members,
                $results['value'],
            );
        }

        return $members;
    }

    // Emulation
    public static function emulateResults(
        ?array $results = null,
        bool $nextLink = false,
    ): array {
        if ($results === null) {
            $results = [self::emulatorExample()];
        }

        $result = [
            '@odata.context' => 'https://graph.microsoft.com/v1.0/$metadata#directoryObjects',
            'value' => $results,
        ];

        if ($nextLink === true) {
            $result['@odata.nextLink'] = 'https://graph.microsoft.com/v1.0/groups/123ab4c5-6789-01de-f2g3-45678hijk9lm/members';
        }

        return $result;
    }

    protected static function emulatorExample(): array
    {
        return [
            '@odata.type' => '#microsoft.graph.user',
            'id' => '123ab4c5-6789-01de-f2g3-45678hijk9lm',
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
        ];
    }

    protected static function emulatorConfig(): array
    {
        return config('entra.emulator.groups');
    }

    protected static function emulateGet(
        string $term,
        string $field,
        bool $nextLink = false,
    ): array {
        $results = [];
        $group = parent::emulateGet($term, $field)['value'][0];

        foreach ($group['members'] as $member) {
            $results[] = [
                '@odata.type' => '#microsoft.graph.user',
                'id' => '123ab4c5-6789-01de-f2g3-45678hijk9lm',
                'mail' => $member,
            ];
        }

        return self::emulateResults($results, $nextLink);
    }
}
