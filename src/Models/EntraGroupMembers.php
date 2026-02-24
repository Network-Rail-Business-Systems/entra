<?php

namespace NetworkRailBusinessSystems\Entra\Models;

use NetworkRailBusinessSystems\Entra\MsGraph;

class EntraGroupMembers
{
    public static function list(
        string $term,
        string $field,
        array $select = ['mail'],
    ): ?array {
        // Find, get ID, list members

        $parameters = http_build_query([
            '$select' => 'mail',
        ]);

        $results = MsGraph::get("groups/$id/members?$parameters");
        dd($results);
        return $results['value'] ?? [];

        // TODO Step over next links to get all results
        return [];
    }

    /** Emulation */
    public static function emulateMemberResults(): array
    {
        return [
            '@odata.context' => 'https://graph.microsoft.com/v1.0/$metadata#directoryObjects',
            '@odata.nextLink' => 'https://graph.microsoft.com/v1.0/groups/123ab4c5-6789-01de-f2g3-45678hijk9lm/members', // In princple, send next-link in get to get next page
            'value' => [
                [
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
                ],
            ],
        ];
    }
}
