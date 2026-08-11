<?php

namespace NetworkRailBusinessSystems\Entra\Traits;

use Faker\Generator;
use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Container\Container;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use NetworkRailBusinessSystems\Entra\Entra;
use NetworkRailBusinessSystems\Entra\Models\EntraUser;

trait AssertsEntra
{
    public bool $entraShouldFail = false;

    public string $entraError = '';

    public string $entraErrorDescription = '';

    public bool $entraShouldReturnEmpty = false;

    public function useEntraEmulator(): void
    {
        Http::fake(function (Request $request) {
            if ($this->entraShouldFail === true) {
                return $this->entraHttpResponse([
                    'error' => $this->entraError,
                    'error_description' => $this->entraErrorDescription,
                ]);
            }

            $data = $request->data();

            // Redeem Code
            if (array_key_exists('code', $data) === true) {
                return $this->entraHttpResponse([
                    'access_token' => 'abc123',
                    'expires_in' => 12345,
                    'ext_expires_in' => 67890,
                    'refresh_token' => 'def456',
                    'scope' => 'scopes',
                    'token_type' => 'Bearer',
                ]);
            }

            // Refresh Token
            if (array_key_exists('refresh_token', $data) === true) {
                return $this->entraHttpResponse([
                    'access_token' => 'abc123',
                    'expires_in' => 12345,
                    'refresh_token' => 'def456',
                    'scope' => 'scopes',
                    'token_type' => 'Bearer',
                ]);
            }

            $url = $request->url();
            $count = $this->entraShouldReturnEmpty === false
                ? 3
                : 0;

            return match (true) {
                str_contains($url, '/$count') => Http::response("$count"),
                str_contains($url, '/users/next-link') => $this->entraHttpResponse(
                    $this->entraUsersResponse($count, false),
                ),
                str_contains($url, '/users') => $this->entraHttpResponse(
                    $this->entraUsersResponse($count, true),
                ),
                str_contains($url, '/me') => $this->entraHttpResponse(
                    $this->entraShouldReturnEmpty === false
                        ? $this->entraFakeUser(false)
                        : [],
                ),
                default => $this->entraHttpResponse([
                    'error' => 'unknown_endpoint',
                    'error_description' => "\"$url\" is not a supported Entra endpoint",
                ]),
            };
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

    public function entraShouldReturnEmpty(): void
    {
        $this->entraShouldReturnEmpty = true;
    }

    public function entraUsersResponse(int $count, bool $nextLink): array
    {
        $response = [
            'value' => [],
        ];

        if ($nextLink === true) {
            $response[Entra::NEXT_LINK] = 'http://localhost/users/next-link';
        }

        for ($current = 0; $current < $count; ++$current) {
            $response['value'][] = $this->entraFakeUser(false);
        }

        return $response;
    }

    public function entraFakeUser(bool $model = true): EntraUser|array
    {
        $faker = $this->faker();

        $data = [
            'department' => $faker->company(),
            'displayName' => $faker->name(),
            'employeeId' => $faker->numerify('#####'),
            'givenName' => $faker->firstName(),
            'id' => $faker->uuid(),
            'jobTitle' => $faker->jobTitle(),
            'mail' => $faker->email(),
            'officeLocation' => $faker->streetAddress(),
            'phone' => $faker->phoneNumber(),
            'surname' => $faker->lastName(),
            'userPrincipalName' => $this->faker()->email(),
        ];

        return $model === true
            ? EntraUser::make($data)
            : $data;
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

    protected function faker(): Generator
    {
        return Container::getInstance()->make(Generator::class);
    }
}
