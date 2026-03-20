<?php

namespace NetworkRailBusinessSystems\Entra\Tests\Unit\Models\EntraUser;

use NetworkRailBusinessSystems\Entra\Facades\MsGraph;
use NetworkRailBusinessSystems\Entra\Facades\MsGraphAdmin;
use NetworkRailBusinessSystems\Entra\Models\EntraUser;
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
                'gandalf@networkrail.co.uk',
                'gimli@networkrail.co.uk',
            ],
            array_column(
                EntraUser::list('g', select: []),
                'userPrincipalName',
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
            EntraUser::list('error'),
        );
    }

    /** @param class-string<MsGraph|MsGraphAdmin> $msGraph */
    protected function check(string $msGraph): void
    {
        $results = EntraUser::emulateResults();

        $parameters = http_build_query([
            '$filter' => 'startsWith(mail, \'a@b.com\')',
            '$select' => '',
            '$top' => 10,
        ]);

        $msGraph::partialMock()
            ->expects('get')
            ->with("users?$parameters")
            ->andReturns($results);

        $this->assertEquals(
            $results['value'],
            EntraUser::list('a@b.com', select: []),
        );
    }
}
