<?php

namespace NetworkRailBusinessSystems\Entra\Tests\Unit\Models\EntraGroup;

use NetworkRailBusinessSystems\Entra\Models\EntraGroup;
use NetworkRailBusinessSystems\Entra\MsGraph;
use NetworkRailBusinessSystems\Entra\Tests\TestCase;

class GetTest extends TestCase
{
    public function testEmulates(): void
    {
        $this->useEntraEmulator();

        $this->assertEquals(
            'fellowship@middle-earth.com',
            EntraGroup::get('fellowship@middle-earth.com')['mail'],
        );
    }

    public function testQueriesEntra(): void
    {
        $results = EntraGroup::emulateResults();

        $parameters = http_build_query([
            '$filter' => 'mail eq \'a@b.com\'',
            '$select' => implode(',', []),
            '$top' => 1,
        ]);

        MsGraph::partialMock()
            ->expects('get')
            ->with("groups?$parameters")
            ->andReturns($results);

        $this->assertEquals(
            'corporate-group@networkrail.co.uk',
            EntraGroup::get('a@b.com')['mail'],
        );
    }
}
