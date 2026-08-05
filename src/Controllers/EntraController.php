<?php

namespace NetworkRailBusinessSystems\Entra\Controllers;

use Error;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Redirect;
use NetworkRailBusinessSystems\Entra\Entra;
use NetworkRailBusinessSystems\Entra\FormRequests\EntraCodeRequest;

class EntraController extends Controller
{
    public function login(): RedirectResponse
    {
        return Entra::isConnected() === true
            ? Redirect::intended()
            : Entra::redirectToEntraLogin();
    }

    public function connect(EntraCodeRequest $request): RedirectResponse
    {
        return Entra::redeemCode($request->input('code')) === true
            ? Redirect::intended()
            : throw new Error(); // TODO Specific
    }

    public function logout(): RedirectResponse
    {
        return Entra::redirectToEntraLogout();
    }
}
