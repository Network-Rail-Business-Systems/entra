<?php

namespace NetworkRailBusinessSystems\Entra\Tests\Unit\Models\EntraGroup;

use NetworkRailBusinessSystems\Entra\Facades\MsGraph;
use NetworkRailBusinessSystems\Entra\Facades\MsGraphAdmin;
use NetworkRailBusinessSystems\Entra\Models\EntraGroup;
use NetworkRailBusinessSystems\Entra\Tests\TestCase;
use stdClass;

class ListTest extends TestCase
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
            [
                'fellowship@middle-earth.com',
            ],
            array_column(
                EntraGroup::list('fellowship@middle-earth.com'),
                'mail',
            ),
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

        $this->assertEmpty(
            EntraGroup::list('error'),
        );
    }

    /** @param class-string<MsGraph|MsGraphAdmin> $msGraph */
    protected function check(string $msGraph): void
    {
        $results = EntraGroup::emulateResults();

        $parameters = http_build_query([
            '$filter' => 'startsWith(mail, \'a@b.com\')',
            '$select' => implode(',', []),
            '$top' => 10,
        ]);

        $msGraph::partialMock()
            ->expects('get')
            ->with("groups?$parameters")
            ->andReturns($results);

        $this->assertEquals(
            $results['value'],
            EntraGroup::list('a@b.com'),
        );
    }
}
