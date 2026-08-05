<?php

namespace NetworkRailBusinessSystems\Entra;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EntraAuthenticated
{
    public function handle(Request $request, Closure $next): mixed
    {
        return Auth::check() === false
            ? Entra::redirectToEntraLogin()
            : $next($request);
    }
}
