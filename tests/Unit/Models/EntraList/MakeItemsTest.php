<?php

namespace NetworkRailBusinessSystems\Entra\Tests\Unit\Models\EntraList;

use NetworkRailBusinessSystems\Entra\Models\EntraList;
use NetworkRailBusinessSystems\Entra\Models\EntraUser;
use NetworkRailBusinessSystems\Entra\Tests\TestCase;

class MakeItemsTest extends TestCase
{
    protected array $items;

    protected function setUp(): void
    {
        parent::setUp();

        $this->items = EntraList::makeItems(
            EntraUser::class,
            $this->entraUsersResponse(3, true),
        );
    }

    public function test(): void
    {
        $this->assertCount(
            3,
            $this->items,
        );

        $this->assertInstanceOf(
            EntraUser::class,
            $this->items[0],
        );
    }
}
