<?php

namespace NetworkRailBusinessSystems\Entra\Tests\Unit\Models\EntraToken;

use NetworkRailBusinessSystems\Entra\Models\EntraToken;
use NetworkRailBusinessSystems\Entra\Tests\TestCase;

class EmulateResultsTest extends TestCase
{
    public function test(): void
    {
        $this->assertEquals(
            'Joe Bloggs',
            EntraToken::emulateResults()['info']['displayName'],
        );
    }
}
