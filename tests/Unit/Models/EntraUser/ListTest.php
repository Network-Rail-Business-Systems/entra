<?php

namespace NetworkRailBusinessSystems\Entra\Tests\Unit\Models\EntraUser;

use NetworkRailBusinessSystems\Entra\Models\EntraUser;
use NetworkRailBusinessSystems\Entra\MsGraph;
use NetworkRailBusinessSystems\Entra\Tests\Data\Users;
use NetworkRailBusinessSystems\Entra\Tests\TestCase;

class ListTest extends TestCase
{
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

    public function testQueriesEntra(): void
    {
        $parameters = http_build_query([
            '$filter' => 'startsWith(mail, \'a@b.com\')',
            '$select' => [],
            '$top' => 10,
        ]);

        MsGraph::partialMock()
            ->expects('get')
            ->with("users?$parameters")
            ->andReturns(
                Users::make(),
            );

        $this->assertEquals(
            Users::make()['value'],
            EntraUser::list('a@b.com', select: []),
        );
    }
}
