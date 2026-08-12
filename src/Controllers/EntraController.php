<?php

namespace NetworkRailBusinessSystems\Entra\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use NetworkRailBusinessSystems\Entra\Entra;
use NetworkRailBusinessSystems\Entra\FormRequests\EntraCodeRequest;
use NetworkRailBusinessSystems\Entra\Interfaces\AuthenticatesWithEntra;
use NetworkRailBusinessSystems\Entra\Models\EntraUser;

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
        $token = Entra::redeemCode(
            $request->input('code'),
        );

        $entraUser = EntraUser::me($token);

        /** @var class-string<AuthenticatesWithEntra> $userModel */
        $userModel = config('entra.models.user');
        $user = $userModel::findOrCreateByAzureId($entraUser->id);

        Auth::login($user);

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
