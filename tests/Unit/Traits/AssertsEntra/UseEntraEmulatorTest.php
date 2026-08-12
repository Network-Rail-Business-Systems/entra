<?php

namespace NetworkRailBusinessSystems\Entra\Tests\Unit\Traits\AssertsEntra;

use NetworkRailBusinessSystems\Entra\Entra;
use NetworkRailBusinessSystems\Entra\Exceptions\EntraException;
use NetworkRailBusinessSystems\Entra\Models\EntraAccessToken;
use NetworkRailBusinessSystems\Entra\Tests\TestCase;

class UseEntraEmulatorTest extends TestCase
{
    protected EntraAccessToken $token;

    protected function setUp(): void
    {
        parent::setUp();

        $this->token = EntraAccessToken::fake();
    }

    public function testShouldFail(): void
    {
        $this->entraShouldFail('Gabba', 'Hey');

        $this->expectException(EntraException::class);
        $this->expectExceptionMessage('Hey');

        Entra::query('/goose', $this->token);
    }

    public function testCode(): void
    {
        $this->assertNotEmpty(
            Entra::redeemCode('abc123'),
        );
    }

    public function testRefreshToken(): void
    {
        $this->assertNotEmpty(
            Entra::refreshToken(
                $this->token,
            ),
        );
    }

    public function testCount(): void
    {
        $this->assertEquals(
            '3',
            Entra::query(
                Entra::entraUserRoute() . '/$count',
                $this->token,
                acceptJson: false,
            ),
        );
    }

    public function testUsersNextLink(): void
    {
        $response = Entra::query(
            Entra::entraUserRoute() . '/next-link',
            $this->token,
        );

        $this->assertArrayNotHasKey(
            Entra::NEXT_LINK,
            $response,
        );
    }

    public function testUsers(): void
    {
        $response = Entra::query(
            Entra::entraUserRoute(),
            $this->token,
        );

        $this->assertArrayHasKey(
            Entra::NEXT_LINK,
            $response,
        );
    }

    public function testMeFull(): void
    {
        $this->assertNotEmpty(
            Entra::query(
                Entra::entraMeRoute(),
                $this->token,
            ),
        );
    }

    public function testMeEmpty(): void
    {
        $this->entraShouldReturnEmpty();

        $this->assertEmpty(
            Entra::query(
                Entra::entraMeRoute(),
                $this->token,
            ),
        );
    }

    public function testBadEndpoint(): void
    {
        $this->expectException(EntraException::class);
        $this->expectExceptionMessage('"goose" is not a supported Entra endpoint');

        Entra::query('/goose', $this->token);
    }
}
