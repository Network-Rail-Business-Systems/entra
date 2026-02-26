<?php

namespace NetworkRailBusinessSystems\Entra\Models;

use Illuminate\Support\Facades\Auth;
use NetworkRailBusinessSystems\Entra\Facades\MsGraph;
use NetworkRailBusinessSystems\Entra\Facades\MsGraphAdmin;

class EntraGroup extends EntraModel
{
    public static function get(
        string $term,
        string $field = 'mail',
        array $select = [],
    ): ?array {
        $parameters = http_build_query([
            '$filter' => "$field eq '$term'",
            '$select' => self::formatSelect($select),
            '$top' => 1,
        ]);

        $results = match (true) {
            self::emulatorIsEnabled() => self::emulateGet($term, $field),
            Auth::check() => MsGraph::get("groups?$parameters"),
            default => MsGraphAdmin::get("groups?$parameters"),
        };

        return $results['value'][0] ?? null;
    }

    public static function list(
        string $term,
        string $field = 'mail',
        array $select = [],
        int $limit = 10,
    ): ?array {
        $parameters = http_build_query([
            '$filter' => "startsWith($field, '$term')",
            '$select' => self::formatSelect($select),
            '$top' => $limit,
        ]);

        $results = match (true) {
            self::emulatorIsEnabled() => self::emulateList($term, $field),
            Auth::check() => MsGraph::get("groups?$parameters"),
            default => MsGraphAdmin::get("groups?$parameters"),
        };

        return $results['value'] ?? [];
    }

    // Emulation
    public static function emulateResults(?array $results = null): array
    {
        if ($results === null) {
            $results = [self::emulatorExample()];
        }

        return [
            '@odata.context' => 'https://graph.microsoft.com/v1.0/$metadata#groups',
            '@odata.nextLink' => 'https://graph.microsoft.com/v1.0/groups',
            'value' => $results,
        ];
    }

    protected static function emulatorExample(): array
    {
        return [
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
        ];
    }

    protected static function emulatorConfig(): array
    {
        $groups = config('entra.emulator.groups');

        foreach ($groups as $index => $group) {
            unset($groups[$index]['members']);
        }

        return $groups;
    }
}
