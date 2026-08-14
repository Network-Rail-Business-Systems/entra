<?php

namespace NetworkRailBusinessSystems\Entra\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use NetworkRailBusinessSystems\Entra\Entra;
use NetworkRailBusinessSystems\Entra\FormRequests\EntraCodeRequest;

class EntraController extends Controller
{
    public function login(): RedirectResponse
    {
        return Auth::check() === true
            ? Entra::redirectToIntended()
            : Entra::redirectToEntraLogin();
    }

    public function connect(EntraCodeRequest $request): RedirectResponse
    {
        $token = Entra::currentToken();

        if ($token !== null) {
            if ($token->hasExpired() === true) {
                $token->refresh();
            }
        } else {
            $token = Entra::redeemCode(
                $request->input('code'),
            );
        }

        Entra::loginUsingToken($token);

        return Entra::redirectToIntended();
    }

    public function logout(): RedirectResponse
    {
        Auth::logout();

        return Redirect::to(
            config('app.url'),
        );
    }
}
