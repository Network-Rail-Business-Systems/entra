<?php

namespace NetworkRailBusinessSystems\Entra\Tests\Unit\Models\EntraGroupMembers;

use NetworkRailBusinessSystems\Entra\Models\EntraGroup;
use NetworkRailBusinessSystems\Entra\Models\EntraGroupMembers;
use NetworkRailBusinessSystems\Entra\MsGraph;
use NetworkRailBusinessSystems\Entra\Tests\TestCase;

class GetTest extends TestCase
{
    public function testNull(): void
    {
        $this->useEntraEmulator();

        $this->assertNull(
            EntraGroupMembers::get('nope@missing.com'),
        );
    }

    public function testEmulates(): void
    {
        $this->useEntraEmulator();

        $this->assertCount(
            18,
            EntraGroupMembers::get('fellowship@middle-earth.com'),
        );
    }

    public function testQueriesEntra(): void
    {
        $groupResults = EntraGroup::emulateResults();
        $memberNextResults = EntraGroupMembers::emulateResults(nextLink: true);
        $memberEndResults = EntraGroupMembers::emulateResults([]);

        $groupParameters = http_build_query([
            '$filter' => 'mail eq \'a@b.com\'',
            '$select' => implode(',', ['id']),
            '$top' => 1,
        ]);

        MsGraph::partialMock()
            ->expects('get')
            ->with("groups?$groupParameters")
            ->andReturns($groupResults);

        $memberParameters = http_build_query([
            '$select' => implode(',', ['mail']),
        ]);

        MsGraph::partialMock()
            ->expects('get')
            ->with("groups/123ab4c5-6789-01de-f2g3-45678hijk9lm/members?$memberParameters")
            ->andReturns($memberNextResults);

        MsGraph::partialMock()
            ->expects('get')
            ->with('https://graph.microsoft.com/v1.0/groups/123ab4c5-6789-01de-f2g3-45678hijk9lm/members')
            ->andReturns($memberEndResults);

        $this->assertCount(
            1,
            EntraGroupMembers::get('a@b.com'),
        );
    }
}
