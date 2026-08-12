<?php

namespace NetworkRailBusinessSystems\Entra\Tests\Unit\Models\EntraList;

use NetworkRailBusinessSystems\Entra\Models\EntraAccessToken;
use NetworkRailBusinessSystems\Entra\Models\EntraList;
use NetworkRailBusinessSystems\Entra\Models\EntraUser;
use NetworkRailBusinessSystems\Entra\Tests\TestCase;

class NextTest extends TestCase
{
    protected EntraList $list;

    protected EntraAccessToken $token;

    protected function setUp(): void
    {
        parent::setUp();

        $this->token = EntraAccessToken::fake();

        $this->list = EntraList::make(
            EntraUser::class,
            $this->token,
            $this->entraUsersResponse(3, true),
        )->next();
    }

    public function test(): void
    {
        $this->assertEquals(
            EntraUser::class,
            $this->list->modelClass,
        );

        $this->assertEquals(
            $this->token,
            $this->list->token,
        );

        $this->assertCount(
            3,
            $this->list->items,
        );

        $this->assertInstanceOf(
            EntraUser::class,
            $this->list->items[0],
        );

        $this->assertNull(
            $this->list->nextLink,
        );
    }
}
