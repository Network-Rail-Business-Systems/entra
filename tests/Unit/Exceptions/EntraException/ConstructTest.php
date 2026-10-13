<?php

namespace NetworkRailBusinessSystems\Entra\Tests\Unit\Exceptions\EntraException;

use NetworkRailBusinessSystems\Entra\Exceptions\EntraException;
use NetworkRailBusinessSystems\Entra\Tests\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;

class ConstructTest extends TestCase
{
    #[DataProvider('expectations')]
    public function test(
        string|array $error,
        string $errorDescription,
        int $code,
        string $message,
        bool $report,
    ): void {
        $exception = new EntraException([
            'error' => $error,
            'error_description' => $errorDescription,
        ], __LINE__);

        $this->assertEquals(
            $code,
            $exception->getCode(),
        );

        $this->assertEquals(
            $message,
            $exception->getMessage(),
        );

        $this->assertEquals(
            $report,
            $exception->report,
        );
    }

    public static function expectations(): array
    {
        return [
            [
                'error' => 'invalid_request',
                'errorDescription' => 'ABCDE123456: The request body must contain the following parameter: \'grant_type\'. Trace ID: abc123',
                'code' => 500,
                'message' => 'We were unable to sign you in due to a server configuration error; contact us for support quoting "The request body must contain the following parameter: \'grant_type\'"',
                'report' => true,
            ],
            [
                'error' => 'invalid_grant',
                'errorDescription' => 'ABCDE123456: The request body must contain the following parameter: \'grant_type\'. Trace ID: abc123',
                'code' => 403,
                'message' => 'We were unable to sign you in because your request has expired; go back and try again',
                'report' => false,
            ],
            [
                'error' => 'temporarily_unavailable',
                'errorDescription' => 'ABCDE123456: The request body must contain the following parameter: \'grant_type\'. Trace ID: abc123',
                'code' => 503,
                'message' => 'We were unable to sign you in because the servers are busy; try again later',
                'report' => false,
            ],
            [
                'error' => 'potato',
                'errorDescription' => 'There is a snake in my boot',
                'code' => 500,
                'message' => 'There is a snake in my boot',
                'report' => true,
            ],
            [
                'error' => [
                    'code' => 'dadadad',
                    'message' => 'potato',
                ],
                'errorDescription' => 'There is a snake in my boot',
                'code' => 500,
                'message' => 'potato',
                'report' => true,
            ],
        ];
    }
}
