<?php

namespace NetworkRailBusinessSystems\Entra;

use Dcblogdev\MsGraph\Facades\MsGraph;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;

class EntraController extends Controller
{
    public function connect(): RedirectResponse
    {
        // TODO Handlers for various access issues; currently throws generic exception

        Session::flash(
            'url.intended',
            URL::previous(),
        );

        return MsGraph::connect();
    }

    public function disconnect(): RedirectResponse
    {
        return MsGraph::disconnect();
    }
}
