<?php

namespace NetworkRailBusinessSystems\Entra\Tests\Unit\Models\EntraUser;

use NetworkRailBusinessSystems\Entra\Facades\MsGraph;
use NetworkRailBusinessSystems\Entra\Facades\MsGraphAdmin;
use NetworkRailBusinessSystems\Entra\Models\EntraUser;
use NetworkRailBusinessSystems\Entra\Tests\TestCase;

class GetTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->useDatabase();
    }

    public function testEmulates(): void
    {
        $this->useDatabase();
        $this->useEntraEmulator();

        $this->assertEquals(
            'Gandalf Stormcrow',
            EntraUser::get('gandalf.stormcrow@networkrail.co.uk')['displayName'],
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

    /** @param class-string<MsGraph|MsGraphAdmin> $msGraph */
    protected function check(string $msGraph): void
    {
        $results = EntraUser::emulateResults();

        $parameters = http_build_query([
            '$filter' => 'mail eq \'a@b.com\'',
            '$select' => implode(
                ',',
                array_keys(
                    config('entra.sync_attributes'),
                ),
            ),
            '$top' => 1,
        ]);

        $msGraph::partialMock()
            ->expects('get')
            ->with("users?$parameters")
            ->andReturns($results);

        $this->assertEquals(
            'Joe Bloggs',
            EntraUser::get('a@b.com')['displayName'],
        );
    }
}
