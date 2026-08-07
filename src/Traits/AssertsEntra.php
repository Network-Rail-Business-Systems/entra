<?php

namespace NetworkRailBusinessSystems\Entra\Traits;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use NetworkRailBusinessSystems\Entra\Tests\Models\User;

trait AssertsEntra
{
    public bool $entraShouldFail = false;

    public string $entraError = '';

    public string $entraErrorDescription = '';

    public function useEntraEmulator(): void
    {
        config()->set('entra', [
            'client' => 'client',
            'proxy' => null,
            'scopes' => '',
            'secret' => 'secret',
            'tenant' => 'tenant',
            'models' => [
                'user' => User::class,
            ],
        ]);

        Http::fake(function (Request $request) {
            $data = $request->data();

            if ($this->entraShouldFail === true) {
                return $this->entraHttpResponse([
                    'error' => $this->entraError,
                    'error_description' => $this->entraErrorDescription,
                ]);
            }

            if (array_key_exists('code', $data) === true) {
                // Redeem Code
                return $this->entraHttpResponse([
                    'access_token' => 'abc123',
                    'expires_in' => 12345,
                    'ext_expires_in' => 67890,
                    'refresh_token' => 'def456',
                    'scope' => 'scopes',
                    'token_type' => 'Bearer',
                ]);
            }

            if (array_key_exists('refresh_token', $data) === true) {
                // Refresh Token
                return $this->entraHttpResponse([
                    'access_token' => 'abc123',
                    'expires_in' => 12345,
                    'refresh_token' => 'def456',
                    'scope' => 'scopes',
                    'token_type' => 'Bearer',
                ]);
            }

            // Me
            return $this->entraHttpResponse([
                'businessPhones' => [
                    '01234567890',
                ],
                'displayName' => 'Joe Bloggs',
                'givenName' => 'Joe',
                'id' => 'abc123',
                'jobTitle' => 'Developer',
                'mail' => 'joe.bloggs@networkrail.co.uk',
                'mobilePhone' => '07712345678',
                'officeLocation' => 'Milton Keynes',
                'surname' => 'Bloggs',
                'userPrincipalName' => 'jbloggs@networkrail.co.uk',
            ]);
        });
    }

    public function entraShouldFail(
        string $error = 'invalid_grant',
        string $description = 'A123: Grant is invalid. Trace ID: abc123',
    ): void {
        $this->entraShouldFail = true;
        $this->entraError = $error;
        $this->entraErrorDescription = $description;
    }

    protected function entraHttpResponse(
        array $properties,
        int $status = 200,
    ): PromiseInterface {
        return Http::response(
            json_encode($properties),
            $status,
        );
    }
}
