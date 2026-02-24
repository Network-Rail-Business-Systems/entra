<?php

namespace NetworkRailBusinessSystems\Entra\Tests\Unit\Models\EntraGroupMembers;

use NetworkRailBusinessSystems\Entra\Models\EntraGroupMembers;
use NetworkRailBusinessSystems\Entra\Models\EntraUser;
use NetworkRailBusinessSystems\Entra\Tests\TestCase;

class EmulateResultsTest extends TestCase
{
    public function testExample(): void
    {
        $this->assertEquals(
            'Joe Bloggs',
            EntraUser::emulateResults()['value'][0]['displayName'],
        );
    }

    public function testCustomised(): void
    {
        $results = EntraGroupMembers::emulateResults([
            [
                'displayName' => 'Joe Bloggs',
            ],
        ], true);

        $this->assertArrayHasKey(
            EntraGroupMembers::NEXT_LINK,
            $results,
        );

        $this->assertEquals(
            'Joe Bloggs',
            $results['value'][0]['displayName'],
        );
    }
}
