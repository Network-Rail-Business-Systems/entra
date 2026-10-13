<?php

namespace NetworkRailBusinessSystems\Entra\Tests\Unit\Exceptions\EntraException;

use NetworkRailBusinessSystems\Entra\Exceptions\EntraException;
use NetworkRailBusinessSystems\Entra\Tests\TestCase;

class ReportTest extends TestCase
{
    protected EntraException $exception;

    protected function setUp(): void
    {
        parent::setUp();

        $this->exception = new EntraException([
            'error' => 'potato',
            'error_description' => 'goose',
        ], 0);
    }

    public function testFalseWhenTrue(): void
    {
        $this->exception->report = true;

        $this->assertFalse(
            $this->exception->report(),
        );
    }

    public function testNullWhenFalse(): void
    {
        $this->exception->report = false;

        $this->assertNull(
            $this->exception->report(),
        );
    }
}
