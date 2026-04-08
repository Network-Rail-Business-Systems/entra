<?php

namespace NetworkRailBusinessSystems\Entra\Tests\Unit\Facades\MsGraph;

use Carbon\Carbon;
use Dcblogdev\MsGraph\Models\MsGraphToken;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use League\OAuth2\Client\Provider\GenericProvider;
use League\OAuth2\Client\Token\AccessToken;
use NetworkRailBusinessSystems\Entra\Facades\MsGraph;
use NetworkRailBusinessSystems\Entra\Models\EntraUser;
use NetworkRailBusinessSystems\Entra\Tests\TestCase;
use PHPUnit\Framework\Attributes\PreserveGlobalState;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;

#[RunTestsInSeparateProcesses]
#[PreserveGlobalState(false)]
class ConnectTest extends TestCase
{
    protected RedirectResponse $redirect;

    protected function setUp(): void
    {
        parent::setUp();

        $this->useDatabase();
    }

    public function testRedirectsToAzure(): void
    {
        request()->headers->set('referer', 'http://localhost/previous');

        $this->configure(
            'http://localhost/entra/connect',
            null,
            false,
        );

        $this->redirect = MsGraph::connect();

        $this->assertEquals(
            'http://localhost/previous',
            Session::get('url.intended'),
        );

        $this->assertStringStartsWith(
            'http://localhost/authorise',
            $this->redirect->getTargetUrl(),
        );
    }

    public function testRedirectsToIntendedPrevious(): void
    {
        Session::put('url.intended', 'http://localhost/previous');

        $this->mock('overload:' . GenericProvider::class, function ($mock) {
            $accessToken = new AccessToken([
                'access_token' => 'abc123',
                'expires' => Carbon::tomorrow()->timestamp,
                'redirect_uri' => 'http://localhost/entra/connect',
                'refresh_token' => 'def456',
                'resource_owner_id' => '1',
            ]);

            $mock->expects('getAccessToken')
                ->andReturns($accessToken);
        });

        Http::fake([
            '*' => EntraUser::emulateResults()['value'][0],
        ]);

        $this->configure(
            'http://localhost/entra/connect',
            'abc123',
            false,
        );

        $this->redirect = MsGraph::connect();

        $this->assertEquals(
            'http://localhost/previous',
            $this->redirect->getTargetUrl(),
        );
    }

    public function testRedirectsToIntendedCurrent(): void
    {
        $this->configure(
            'http://localhost/current',
            null,
            true,
        );

        $this->redirect = MsGraph::connect();

        $this->assertEquals(
            'http://localhost/current',
            $this->redirect->getTargetUrl(),
        );
    }

    protected function configure(
        string $currentRoute,
        ?string $code,
        ?bool $connected,
    ): void {
        request()->server->set('REQUEST_URI', $currentRoute);

        if ($code !== null) {
            request()->query->set('code', $code);
        }

        if ($connected === true) {
            MsGraphToken::create([
                'access_token' => 'abc123',
                'expires' => Carbon::tomorrow()->timestamp,
                'refresh_token' => 'def456',
                'user_id' => $this->signIn()->id,
            ]);
        }
    }
}
