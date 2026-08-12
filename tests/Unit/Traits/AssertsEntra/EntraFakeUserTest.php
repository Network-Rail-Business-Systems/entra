<?php

namespace NetworkRailBusinessSystems\Entra\Tests\Unit\Traits\AssertsEntra;

use NetworkRailBusinessSystems\Entra\Models\EntraUser;
use NetworkRailBusinessSystems\Entra\Tests\TestCase;

class EntraFakeUserTest extends TestCase
{
    public function testModel(): void
    {
        $this->entraFakeUser();

        $this->assertInstanceOf(
            EntraUser::class,
            $this->entraFakeUser(),
        );
    }

    public function testArray(): void
    {
        $this->assertIsArray(
            $this->entraFakeUser(false),
        );
    }
}
