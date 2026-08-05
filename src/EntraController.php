<?php

namespace NetworkRailBusinessSystems\Entra;

use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

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

        $entraUser = Entra::me($token);

        /** @var class-string<AuthenticatesWithEntra> $userModel */
        $userModel = config('entra.user_model');
        $user = $userModel::findOrCreateByAzureId($entraUser->id);

        Auth::login($user);

        return Entra::redirectToIntended();
    }
}
