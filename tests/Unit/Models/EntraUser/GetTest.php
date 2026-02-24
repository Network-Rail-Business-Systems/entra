<?php

namespace NetworkRailBusinessSystems\Entra\Tests\Unit\Models\EntraUser;

use NetworkRailBusinessSystems\Entra\Models\EntraUser;
use NetworkRailBusinessSystems\Entra\MsGraph;
use NetworkRailBusinessSystems\Entra\Tests\TestCase;

class GetTest extends TestCase
{
    public function testEmulates(): void
    {
        $this->useEntraEmulator();

        $this->assertEquals(
            'Gandalf Stormcrow',
            EntraUser::get('gandalf.stormcrow@networkrail.co.uk')['displayName'],
        );
    }

    public function testQueriesEntra(): void
    {
        $results = EntraUser::emulateResults();

        $parameters = http_build_query([
            '$filter' => 'mail eq \'a@b.com\'',
            '$select' => implode(',', config('entra.sync_attributes')),
            '$top' => 1,
        ]);

        MsGraph::partialMock()
            ->expects('get')
            ->with("users?$parameters")
            ->andReturns($results);

        $this->assertEquals(
            'Joe Bloggs',
            EntraUser::get('a@b.com')['displayName'],
        );
    }
}
