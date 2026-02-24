<?php

namespace NetworkRailBusinessSystems\Entra\Tests\Unit\Models\EntraGroup;

use NetworkRailBusinessSystems\Entra\Models\EntraGroup;
use NetworkRailBusinessSystems\Entra\Tests\TestCase;

class EmulateResultsTest extends TestCase
{
    public function testExample(): void
    {
        $this->assertEquals(
            'CorporateGroup',
            EntraGroup::emulateResults()['value'][0]['displayName'],
        );
    }

    public function testCustomised(): void
    {
        $this->assertEquals(
            'a@b.com',
            EntraGroup::emulateResults([
                [
                    'mail' => 'a@b.com',
                ],
            ])['value'][0]['mail'],
        );
    }
}
