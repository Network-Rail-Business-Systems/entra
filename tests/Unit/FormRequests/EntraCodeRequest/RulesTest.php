<?php

namespace NetworkRailBusinessSystems\Entra\Tests\Unit\FormRequests\EntraCodeRequest;

use NetworkRailBusinessSystems\Entra\FormRequests\EntraCodeRequest;
use NetworkRailBusinessSystems\Entra\Rules\EntraStateMatches;
use NetworkRailBusinessSystems\Entra\Tests\TestCase;

class RulesTest extends TestCase
{
    protected EntraCodeRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new EntraCodeRequest();
    }

    public function test(): void
    {
        $this->assertEquals(
            [
                'code' => [
                    'required',
                    'string',
                ],
                'state' => [
                    'required',
                    'string',
                    new EntraStateMatches(),
                ],
                'session_state' => [
                    'required',
                    'string',
                ],
            ],
            $this->request->rules(),
        );
    }
}
