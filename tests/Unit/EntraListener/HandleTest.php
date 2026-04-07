<?php

namespace NetworkRailBusinessSystems\Entra\Tests\Unit\EntraListener;

use Dcblogdev\MsGraph\Events\NewMicrosoft365SignInEvent;
use Illuminate\Support\Facades\Auth;
use NetworkRailBusinessSystems\Entra\EntraListener;
use NetworkRailBusinessSystems\Entra\Exceptions\OnlyExistingUsersException;
use NetworkRailBusinessSystems\Entra\Models\EntraToken;
use NetworkRailBusinessSystems\Entra\Tests\Models\User;
use NetworkRailBusinessSystems\Entra\Tests\TestCase;

class HandleTest extends TestCase
{
    protected array $token;

    protected EntraListener $listener;

    protected NewMicrosoft365SignInEvent $event;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->useDatabase();

        $this->token = EntraToken::emulateResults();
        $this->event = new NewMicrosoft365SignInEvent($this->token);

        $this->listener = new EntraListener();
    }

    public function test(): void
    {
        $this->listener->handle($this->event);

        $this->assertDatabaseHas('users', [
            'id' => 1,
        ]);

        $this->user = User::query()->find(1);

        $this->assertDatabaseHas('ms_graph_tokens', [
            'access_token' => $this->token['accessToken'],
            'email' => $this->user->email,
            'expires' => $this->token['expires'],
            'refresh_token' => $this->token['refreshToken'],
            'user_id' => $this->user->id,
        ]);

        $this->assertEquals(
            $this->user->id,
            Auth::id(),
        );
    }

    public function testBlocksCreate(): void
    {
        $this->expectException(OnlyExistingUsersException::class);
        $this->expectExceptionMessage('only_existing');

        config()->set('entra.create_users', false);

        $this->listener->handle($this->event);

        $this->assertDatabaseEmpty('users');
    }
}
