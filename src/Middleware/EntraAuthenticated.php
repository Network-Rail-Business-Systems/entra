<?php

namespace NetworkRailBusinessSystems\Entra\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use NetworkRailBusinessSystems\Entra\Entra;

class EntraAuthenticated
{
    public function handle(Request $request, Closure $next): mixed
    {
        return Auth::check() === false
            ? Entra::redirectToEntraLogin()
            : $next($request);
    }
}
