<?php

namespace NetworkRailBusinessSystems\Entra\Tests\Unit\Models\EntraGroupMembers;

use NetworkRailBusinessSystems\Entra\Facades\MsGraph;
use NetworkRailBusinessSystems\Entra\Facades\MsGraphAdmin;
use NetworkRailBusinessSystems\Entra\Models\EntraGroup;
use NetworkRailBusinessSystems\Entra\Models\EntraGroupMembers;
use NetworkRailBusinessSystems\Entra\Tests\TestCase;
use stdClass;

class GetTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->useDatabase();
    }

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

    public function testQueriesAsUser(): void
    {
        $this->signIn();
        $this->check(MsGraph::class);
    }

    public function testQueriesAsAdmin(): void
    {
        $this->check(MsGraphAdmin::class);
    }

    public function testHandlesError(): void
    {
        $this->signIn();

        MsGraph::partialMock()
            ->expects('get')
            ->twice()
            ->andReturns(
                EntraGroup::emulateResults(),
                new stdClass(),
            );

        $this->assertEmpty(
            EntraGroupMembers::get('error'),
        );
    }

    /** @param class-string<MsGraph|MsGraphAdmin> $msGraph */
    protected function check(string $msGraph): void
    {
        $groupResults = EntraGroup::emulateResults();
        $memberNextResults = EntraGroupMembers::emulateResults(nextLink: true);
        $memberEndResults = EntraGroupMembers::emulateResults([]);

        $groupParameters = http_build_query([
            '$filter' => 'mail eq \'a@b.com\'',
            '$select' => implode(',', ['id']),
            '$top' => 1,
        ]);

        $msGraph::partialMock()
            ->expects('get')
            ->with("groups?$groupParameters")
            ->andReturns($groupResults);

        $memberParameters = http_build_query([
            '$select' => implode(',', ['mail']),
        ]);

        $msGraph::partialMock()
            ->expects('get')
            ->with("groups/123ab4c5-6789-01de-f2g3-45678hijk9lm/members?$memberParameters")
            ->andReturns($memberNextResults);

        $msGraph::partialMock()
            ->expects('get')
            ->with('https://graph.microsoft.com/v1.0/groups/123ab4c5-6789-01de-f2g3-45678hijk9lm/members')
            ->andReturns($memberEndResults);

        $this->assertCount(
            1,
            EntraGroupMembers::get('a@b.com'),
        );
    }
}
