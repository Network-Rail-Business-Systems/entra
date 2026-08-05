<?php

namespace NetworkRailBusinessSystems\Entra\Middleware;

use Closure;
use Illuminate\Http\Request;
use NetworkRailBusinessSystems\Entra\Entra;

class EntraAuthenticated
{
    public function handle(Request $request, Closure $next): mixed
    {
        return Entra::isConnected() === false
            ? Entra::redirectToEntraLogin()
            : $next($request);
    }
}
