<?php

namespace NetworkRailBusinessSystems\Entra\Tests\Unit\Models\EntraGroup;

use NetworkRailBusinessSystems\Entra\Facades\MsGraph;
use NetworkRailBusinessSystems\Entra\Facades\MsGraphAdmin;
use NetworkRailBusinessSystems\Entra\Models\EntraGroup;
use NetworkRailBusinessSystems\Entra\Tests\TestCase;
use stdClass;

class GetTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->useDatabase();
    }

    public function testEmulates(): void
    {
        $this->useEntraEmulator();

        $this->assertEquals(
            'fellowship@middle-earth.com',
            EntraGroup::get('fellowship@middle-earth.com')['mail'],
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
            ->andReturns(new stdClass());

        $this->assertNull(
            EntraGroup::get('error'),
        );
    }

    /** @param class-string<MsGraph|MsGraphAdmin> $msGraph */
    protected function check(string $msGraph): void
    {
        $results = EntraGroup::emulateResults();

        $parameters = http_build_query([
            '$filter' => 'mail eq \'a@b.com\'',
            '$select' => implode(',', []),
            '$top' => 1,
        ]);

        $msGraph::partialMock()
            ->expects('get')
            ->with("groups?$parameters")
            ->andReturns($results);

        $this->assertEquals(
            'corporate-group@networkrail.co.uk',
            EntraGroup::get('a@b.com')['mail'],
        );
    }
}
