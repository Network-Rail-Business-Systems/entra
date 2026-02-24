<?php

namespace NetworkRailBusinessSystems\Entra\Models;

use NetworkRailBusinessSystems\Entra\MsGraph;

class EntraGroup
{
    public static function get(
        string $term,
        string $field = 'mail',
        array $select = [],
    ): ?array {
        // TODO
        return [];
    }

    public static function list(
        string $term,
        string $field = 'mail',
        array $select = [],
        int $limit = 10,
    ): ?array {
        // TODO

        $parameters = http_build_query([
            '$filter' => "startsWith($field, '$term')",
//            '$select' => self::formatSelect($select),
            '$top' => $limit,
        ]);


        $results = MsGraph::get("groups?$parameters");
        dd($results);
        return $results['value'] ?? [];

        return [];
    }

    /** Emulation */
    public static function emulateGroupResults(): array
    {
        return [
            '@odata.context' => 'https://graph.microsoft.com/v1.0/$metadata#groups',
            '@odata.nextLink' => 'https://graph.microsoft.com/v1.0/groups',
            'value' => [
                [
                    'id' => '123ab4c5-6789-01de-f2g3-45678hijk9lm',
                    'deletedDateTime' => null,
                    'classification' => null,
                    'createdDateTime' => '2026-02-23T11:44:40Z',
                    'creationOptions' => [],
                    'description' => 'Corporate Group',
                    'displayName' => 'CorporateGroup',
                    'expirationDateTime' => null,
                    'groupTypes' => [],
                    'isAssignableToRole' => null,
                    'mail' => 'corporate-group@networkrail.co.uk',
                    'mailEnabled' => true,
                    'mailNickname' => 'CorporateGroup',
                    'membershipRule' => null,
                    'membershipRuleProcessingState' => null,
                    'onPremisesDomainName' => 'domain.mail.net',
                    'onPremisesLastSyncDateTime' => '2026-02-23T00:19:38Z',
                    'onPremisesNetBiosName' => 'NETBIOS',
                    'onPremisesSamAccountName' => 'CorporateGroup',
                    'onPremisesSecurityIdentifier' => 'A-1-2-34-567890123-123456789-123456789-12345',
                    'onPremisesSyncEnabled' => true,
                    'preferredDataLocation' => null,
                    'preferredLanguage' => null,
                    'proxyAddresses' => [
                        'SMTP:corporate-group@networkrail.co.uk',
                    ],
                    'renewedDateTime' => '2026-02-23T11:44:40Z',
                    'resourceBehaviorOptions' => [],
                    'resourceProvisioningOptions' => [],
                    'securityEnabled' => true,
                    'securityIdentifier' => 'A-1-2-34-567890123-123456789-123456789-12345',
                    'theme' => null,
                    'uniqueName' => null,
                    'visibility' => null,
                    'onPremisesProvisioningErrors' => [],
                    'serviceProvisioningErrors' => [],
                ],
            ],
        ];
    }
}
