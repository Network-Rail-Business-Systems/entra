<?php

namespace NetworkRailBusinessSystems\Entra;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;
use NetworkRailBusinessSystems\Entra\Interfaces\EntraAuthenticatable;

class Entra
{
    // Authentication
    public static function isConnected(): bool
    {
        /** @var ?EntraAuthenticatable $user */
        $user = Auth::user();

        return $user !== null
            && $user->needsToReauthenticate() === false;
    }

    public static function redeemCode(string $code): bool
    {
        // TODO Attempt to redeem code into access token
        // Capture specific errors
        // TODO User session may not exist

        /** @var ?EntraAuthenticatable $user */
        $user = Auth::user();
    }

    // Querying
    public static function query(EntraAuthenticatable $user): PendingRequest
    {
        // TODO endpoints, proxy, filters, DTOs
        // TODO Use generic account option
        // https://learn.microsoft.com/en-us/graph/auth-v2-user?tabs=http

        return Http::asJson()
            ->withToken($user->entraToken->access_token);
    }

    public static function getGenericAccessToken()
    {

        return Http::asJson()
            ->get('https://login.microsoftonline.com/c22cc3e1-5d7f-4f4d-be03-d5a158cc9409/oauth2/v2.0/authorize', [
                'client_id' => '17dfa82f-473b-4542-89f4-1b114425261c',
                'state' => '12345',
                'scope' => 'User.Read.All offline_access Group.Read.All',
                'redirect_uri' => 'http://localhost/entra/connect',
                'response_type' => 'code',
                'response_mode' => 'query',
                'code_challenge' => 'YTFjNjI1OWYzMzA3MTI4ZDY2Njg5M2RkNmVjNDE5YmEyZGRhOGYyM2IzNjdmZWFhMTQ1ODg3NDcxY2Nl',
                'code_challenge_method' => 'S256',
            ])
            ->body();
    }

    // Redirection
    public static function redirectToEntraLogin(): RedirectResponse
    {
        // TODO Capture intended

        return Redirect::to(
            self::entraLoginRoute(),
        );
    }

    public static function redirectToEntraLogout(): RedirectResponse
    {
        return Redirect::to(
            self::entraLogoutRoute(),
        );
    }

    // Routing
    public static function entraLoginRoute(): string
    {
        // TODO
    }

    public static function entraLogoutRoute(): string
    {
        // TODO
    }
}
