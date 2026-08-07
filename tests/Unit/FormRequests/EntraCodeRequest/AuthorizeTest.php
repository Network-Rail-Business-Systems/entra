<?php

namespace NetworkRailBusinessSystems\Entra\Tests\Unit\FormRequests\EntraCodeRequest;

use NetworkRailBusinessSystems\Entra\FormRequests\EntraCodeRequest;
use NetworkRailBusinessSystems\Entra\Tests\TestCase;

class AuthorizeTest extends TestCase
{
    protected EntraCodeRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new EntraCodeRequest();
    }

    public function test(): void
    {
        $this->assertTrue(
            $this->request->authorize(),
        );
    }
}
