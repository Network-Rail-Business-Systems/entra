<?php

namespace NetworkRailBusinessSystems\Entra\Tests\Unit\EntraUser;

use NetworkRailBusinessSystems\Entra\Models\EntraUser;
use NetworkRailBusinessSystems\Entra\MsGraph;
use NetworkRailBusinessSystems\Entra\Tests\Data\Users;
use NetworkRailBusinessSystems\Entra\Tests\TestCase;

class ListTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

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
    }

    public function test(): void
    {
        $this->assertEquals(
            Users::make()['value'],
            EntraUser::list('a@b.com', select: []),
        );
    }
}
