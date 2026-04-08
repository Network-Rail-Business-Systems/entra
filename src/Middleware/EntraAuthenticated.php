<?php

namespace NetworkRailBusinessSystems\Entra\Middleware;

use Closure;
use Illuminate\Http\Request;
use NetworkRailBusinessSystems\Entra\Facades\MsGraph;

class EntraAuthenticated
{
    public function handle(Request $request, Closure $next): mixed
    {
        if (MsGraph::isConnected() === false) {
            return MsGraph::connect();
        }

        return $next($request);
    }
}
