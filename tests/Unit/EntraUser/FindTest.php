<?php

namespace NetworkRailBusinessSystems\Entra\Tests\Unit\EntraUser;

use NetworkRailBusinessSystems\Entra\Models\EntraUser;
use NetworkRailBusinessSystems\Entra\MsGraph;
use NetworkRailBusinessSystems\Entra\Tests\Data\Users;
use NetworkRailBusinessSystems\Entra\Tests\TestCase;

class FindTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $parameters = http_build_query([
            '$filter' => 'mail eq \'a@b.com\'',
            '$select' => config('entra.sync_attributes'),
            '$top' => 1,
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
            'Joe Bloggs',
            EntraUser::find('a@b.com')['displayName'],
        );
    }
}
