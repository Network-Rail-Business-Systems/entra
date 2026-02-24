<?php

namespace NetworkRailBusinessSystems\Entra\Tests\Unit\Models\EntraGroup;

use NetworkRailBusinessSystems\Entra\Models\EntraGroup;
use NetworkRailBusinessSystems\Entra\MsGraph;
use NetworkRailBusinessSystems\Entra\Tests\TestCase;

class ListTest extends TestCase
{
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

    public function testQueriesEntra(): void
    {
        $results = EntraGroup::emulateResults();

        $parameters = http_build_query([
            '$filter' => 'startsWith(mail, \'a@b.com\')',
            '$select' => implode(',', []),
            '$top' => 10,
        ]);

        MsGraph::partialMock()
            ->expects('get')
            ->with("groups?$parameters")
            ->andReturns($results);

        $this->assertEquals(
            $results['value'],
            EntraGroup::list('a@b.com'),
        );
    }
}
