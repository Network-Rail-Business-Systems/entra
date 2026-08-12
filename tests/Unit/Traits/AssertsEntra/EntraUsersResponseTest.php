<?php

namespace NetworkRailBusinessSystems\Entra\Tests\Unit\Traits\AssertsEntra;

use NetworkRailBusinessSystems\Entra\Entra;
use NetworkRailBusinessSystems\Entra\Tests\TestCase;

class EntraUsersResponseTest extends TestCase
{
    protected array $response;

    protected function setUp(): void
    {
        parent::setUp();

        $this->response = $this->entraUsersResponse(3, true);
    }

    public function test(): void
    {
        $this->assertEquals(
            'http://localhost/users/next-link',
            $this->response[Entra::NEXT_LINK],
        );

        $this->assertCount(3, $this->response['value']);
    }
}
