<?php

namespace NetworkRailBusinessSystems\Entra\Tests\Unit\EntraController;

use ErrorException;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;
use NetworkRailBusinessSystems\Entra\EntraController;
use NetworkRailBusinessSystems\Entra\Facades\MsGraph;
use NetworkRailBusinessSystems\Entra\Tests\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;

class ConnectTest extends TestCase
{
    protected EntraController $controller;

    protected RedirectResponse $redirect;

    protected function setUp(): void
    {
        parent::setUp();

        $this->useDatabase();

        request()->headers->set('referer', 'https://networkrail.co.uk/a-page');

        $this->controller = new EntraController();
    }

    public function test(): void
    {
        $this->redirect = $this->controller->connect();

        $this->assertEquals(
            'https://networkrail.co.uk/a-page',
            Session::get('url.intended'),
        );

        $this->assertStringStartsWith(
            'https://login.microsoftonline.com/common/oauth2/v2.0/authorize',
            $this->redirect->getTargetUrl(),
        );
    }

    #[DataProvider('exceptions')]
    public function testHandlesExceptions(string $code, string $message): void
    {
        $this->expectException(ErrorException::class);
        $this->expectExceptionMessage($message);

        MsGraph::partialMock()
            ->expects('connect')
            ->andThrows(
                new Exception("$code A101010: A very technical error message"),
            );

        $this->redirect = $this->controller->connect();
    }

    public static function exceptions(): array
    {
        return [
            [
                'code' => 'unsupported_grant_type',
                'message' => 'We were unable to sign you in due to a server configuration error; contact us for support quoting "unsupported_grant_type"',
            ],
            [
                'code' => 'invalid_grant',
                'message' => 'We were unable to sign you in because your request has expired; go back and try again',
            ],
            [
                'code' => 'temporarily_unavailable',
                'message' => 'We were unable to sign you in because the servers are busy; try again later',
            ],
            [
                'code' => 'goose_attack',
                'message' => 'We were unable to sign you in; try again later',
            ],
        ];
    }
}
