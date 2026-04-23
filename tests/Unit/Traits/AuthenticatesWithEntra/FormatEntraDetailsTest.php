<?php

namespace NetworkRailBusinessSystems\Entra\Tests\Unit\Traits\AuthenticatesWithEntra;

use NetworkRailBusinessSystems\Entra\Tests\Models\User;
use NetworkRailBusinessSystems\Entra\Tests\TestCase;

class FormatEntraDetailsTest extends TestCase
{
    public function test(): void
    {
        $this->assertEquals(
            [
                'a' => 1,
                'b' => 2,
                'c' => 3,
                'mail' => 'gandalf.stormcrow@example.com',
            ],
            User::formatEntraDetails([
                'a' => 1,
                'b' => [2],
                'c' => [3, 2, 1],
                'mail' => 'gandalf.stormcrow@example.com',
            ]),
        );
    }
}
