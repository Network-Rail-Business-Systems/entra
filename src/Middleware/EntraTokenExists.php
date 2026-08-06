<?php

namespace NetworkRailBusinessSystems\Entra\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use NetworkRailBusinessSystems\Entra\Entra;

class EntraTokenExists
{
    public function handle(Request $request, Closure $next): mixed
    {
        return Auth::check() === false
            || Session::has(Entra::ENTRA_TOKEN) === false
            ? Entra::redirectToEntraLogin()
            : $next($request);
    }
}
