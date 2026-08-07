<?php

namespace NetworkRailBusinessSystems\Entra\Tests\Unit\Rules\EntraStateMatches;

use Illuminate\Support\Facades\Session;
use NetworkRailBusinessSystems\Entra\Entra;
use NetworkRailBusinessSystems\Entra\Rules\EntraStateMatches;
use NetworkRailBusinessSystems\Entra\Tests\TestCase;

class ValidateTest extends TestCase
{
    protected EntraStateMatches $rule;

    protected function setUp(): void
    {
        parent::setUp();

        $this->rule = new EntraStateMatches();

        Session::put(Entra::ENTRA_STATE, 'hey');
    }

    public function testFailsWhenMissing(): void
    {
        Session::forget(Entra::ENTRA_STATE);

        $this->assertRuleFails(
            $this->rule,
            'state',
            'gabba',
            'Entra state is expired or missing',
        );
    }

    public function testFailsWhenMismatch(): void
    {
        $this->assertRuleFails(
            $this->rule,
            'state',
            'gabba',
            'Entra state does not match',
        );
    }

    public function testPasses(): void
    {
        $this->assertRulePasses(
            $this->rule,
            'state',
            'hey',
        );
    }
}
