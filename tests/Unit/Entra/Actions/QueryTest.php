<?php

namespace NetworkRailBusinessSystems\Entra\Tests\Unit\Entra\Actions;

use Carbon\Carbon;
use NetworkRailBusinessSystems\Entra\Entra;
use NetworkRailBusinessSystems\Entra\Exceptions\EntraException;
use NetworkRailBusinessSystems\Entra\Models\EntraAccessToken;
use NetworkRailBusinessSystems\Entra\Tests\TestCase;

class QueryTest extends TestCase
{
    protected EntraAccessToken $token;

    protected function setUp(): void
    {
        parent::setUp();

        $this->token = EntraAccessToken::fake();
        $this->token->expires_at = Carbon::yesterday();
    }

    public function testJson(): void
    {
        $this->assertIsArray(
            Entra::query(
                Entra::entraMeRoute(),
                $this->token,
                'mail eq \'a@b.com\'',
                ['mail'],
                3,
                ['Content-Type' => 'text/json'],
            ),
        );
    }

    public function testException(): void
    {
        $this->entraShouldFail('Gabba', 'Hey');

        $this->expectException(EntraException::class);
        $this->expectExceptionMessage('Hey');

        Entra::query(
            Entra::entraMeRoute(),
            $this->token,
        );
    }

    public function testString(): void
    {
        $this->assertIsString(
            Entra::query(
                Entra::entraUserRoute() . '/$count',
                $this->token,
                acceptJson: false,
            ),
        );
    }
}
