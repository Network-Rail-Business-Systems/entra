<?php

namespace NetworkRailBusinessSystems\Entra\Exceptions;

use ErrorException;
use Illuminate\Support\Str;
use NetworkRailBusinessSystems\Entra\Entra;

class EntraException extends ErrorException
{
    public bool $report = true;

    public function __construct(array $response, int $line)
    {
        $errorCode = $response['error']['code']
            ?? $response['error'];

        $errorDescription = $response['error']['message']
            ?? $response['error_description'];

        $error = Str::of($errorDescription)
            ->between(': ', '. Trace ID:')
            ->toString();

        $message = match ($errorCode) {
            'interaction_required',
            'invalid_client',
            'invalid_request',
            'invalid_resource',
            'unauthorized_client',
            'unsupported_grant_type' => "We were unable to sign you in due to a server configuration error; contact us for support quoting \"$error\"",
            'invalid_grant' => 'We were unable to sign you in because your request has expired; go back and try again',
            'temporarily_unavailable' => 'We were unable to sign you in because the servers are busy; try again later',
            default => $error,
        };

        $code = match ($errorCode) {
            'invalid_grant',
            'interaction_required' => 403,
            'temporarily_unavailable' => 503,
            // 'invalid_client',
            // 'invalid_request',
            // 'invalid_resource',
            // 'unauthorized_client',
            // 'unsupported_grant_type',
            default => 500,
        };

        $this->report = match ($errorCode) {
            'invalid_grant',
            'temporarily_unavailable' => false,
            default => true,
        };

        parent::__construct(
            $message,
            $code,
            E_ERROR,
            Entra::class,
            $line,
        );
    }

    public function report(): ?false
    {
        return $this->report === true
            ? false
            : null;
    }
}
