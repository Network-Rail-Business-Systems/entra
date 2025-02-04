<?php

namespace NetworkRailBusinessSystems\Entra;

use Dcblogdev\MsGraph\Facades\MsGraph;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;

class EntraController extends Controller
{
    public function connect(): RedirectResponse
    {
        // TODO Handlers for various access issues; currently throws generic exception
        return MsGraph::connect();
    }

    public function disconnect(): RedirectResponse
    {
        return MsGraph::disconnect();
    }
}
