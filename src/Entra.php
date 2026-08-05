<?php

namespace NetworkRailBusinessSystems\Entra;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class Entra
{
    public const string ENTRA_INTENDED = 'entra_intended';

    public const string ENTRA_STATE = 'entra_state';

    public static function me(EntraAccessToken $token): EntraUser
    {
        $response = Http::withOptions([
            'proxy' => config('entra.proxy'),
        ])
            ->withToken($token->accessToken)
            ->acceptJson()
            ->get(self::entraMeRoute())
            ->json();

        return new EntraUser(
            $response['id'],
            $response['userPrincipalName'],
            $response['mail'],
            $response['displayName'],
            $response['givenName'],
            $response['surname'],
            $response['jobTitle'],
            $response['officeLocation'],
            $response['businessPhones'],
            $response['mobilePhone'],
        );
    }

    public static function redeemCode(string $code): EntraAccessToken
    {
        $response = Http::withOptions([
            'proxy' => config('entra.proxy'),
        ])
            ->acceptJson()
            ->post(
                self::entraRedeemCodeRoute(),
                [
                    'code' => $code,
                    'client_id' => config('entra.client'),
                    'scope' => config('entra.scopes'),
                    'redirect_uri' => self::redirectUrlRoute(),
                    'grant_type' => 'authorization_code',
                    'client_secret' => config('entra.secret'),
                ],
            )
            ->json();

        return new EntraAccessToken(
            $response['access_token'],
            $response['expires_in'],
            $response['refresh_token'],
            $response['scope'],
            $response['token_type'],
            $response['ext_expires_in'],
        );
    }

    // Redirects
    public static function redirectToEntraLogin(): RedirectResponse
    {
        Session::put(
            self::ENTRA_INTENDED,
            Session::get('url.intended'),
        );

        return Redirect::to(
            self::entraLoginRoute(),
        );
    }

    public static function redirectToIntended(): RedirectResponse
    {
        return Redirect::to(
            self::intendedRoute(),
        );
    }

    // Routes
    public static function entraLoginRoute(): string
    {
        $tenant = config('entra.tenant');
        $state = Str::random();

        Session::put(self::ENTRA_STATE, $state);

        return URL::to(
            "https://login.microsoftonline.com/$tenant/oauth2/v2.0/authorize",
            [
                'client_id' => config('entra.client'),
                'response_type' => 'code',
                'redirect_uri' => self::redirectUrlRoute(),
                'response_mode' => 'query',
                'scope' => config('entra.scopes'),
                'state' => $state,
            ],
        );
    }

    public static function entraMeRoute(): string
    {
        return 'https://graph.microsoft.com/v1.0/me';
    }

    public static function entraRedeemCodeRoute(): string
    {
        $tenant = config('entra.tenant');

        return URL::to("https://login.microsoftonline.com/$tenant/oauth2/v2.0/token");
    }

    public static function redirectUrlRoute(): string
    {
        return config('app.url') . '/entra/connect';
    }

    public static function intendedRoute(): string
    {
        return Session::get(self::ENTRA_INTENDED)
            ?? Redirect::intended()->getTargetUrl();
    }
}
