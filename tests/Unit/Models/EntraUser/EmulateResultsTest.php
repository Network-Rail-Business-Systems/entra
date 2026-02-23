<?php

namespace NetworkRailBusinessSystems\Entra\Tests\Unit\Models\EntraUser;

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
        $this->assertEquals(
            [
                '01234567890',
            ],
            EntraUser::emulateResults([
                [
                    'businessPhones' => '01234567890',
                ],
            ])['value'][0]['businessPhones'],
        );
    }
}
