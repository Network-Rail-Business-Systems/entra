<?php

namespace NetworkRailBusinessSystems\Entra\Tests\Unit;

use Dcblogdev\MsGraph\Events\NewMicrosoft365SignInEvent;
use Illuminate\Support\Facades\Auth;
use NetworkRailBusinessSystems\Entra\EntraListener;
use NetworkRailBusinessSystems\Entra\Tests\Data\Token;
use NetworkRailBusinessSystems\Entra\Tests\Data\User;
use NetworkRailBusinessSystems\Entra\Tests\TestCase;

class EntraListenerTest extends TestCase
{
    protected array $token;

    protected EntraListener $listener;

    protected NewMicrosoft365SignInEvent $event;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->useDatabase();

        $this->token = Token::make();
        $this->event = new NewMicrosoft365SignInEvent($this->token);

        $this->listener = new EntraListener();
        $this->listener->handle($this->event);
    }

    public function test(): void
    {
        $this->assertDatabaseHas('users', [
            'id' => 1,
        ]);

        $this->user = User::find(1);

        $this->assertDatabaseHas('ms_graph_tokens', [
            'access_token' => $this->token['accessToken'],
            'email' => $this->user->email,
            'expires' => $this->token['expires'],
            'refresh_token' => $this->token['refreshToken'],
            'user_id' => $this->user->id,
        ]);

        $this->assertEquals(
            $this->user->id,
            Auth::user()->id,
        );
    }
}
