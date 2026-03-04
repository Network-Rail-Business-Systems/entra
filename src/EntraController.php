<?php

namespace NetworkRailBusinessSystems\Entra;

use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Exception;
use ErrorException;
use NetworkRailBusinessSystems\Entra\Facades\MsGraph;

class EntraController extends Controller
{
    public function connect(): RedirectResponse
    {
        Session::flash(
            'url.intended',
            URL::previous(),
        );

        try {
            return MsGraph::connect();
        } catch (Exception $exception) {
            $code = explode(
                ' ',
                $exception->getMessage(),
                2,
            )[0];

            throw new ErrorException(
                match ($code) {
                    'interaction_required',
                    'invalid_client',
                    'invalid_request',
                    'invalid_resource',
                    'unauthorized_client',
                    'unsupported_grant_type' => "We were unable to sign you in due to a server configuration error; contact us for support quoting \"$code\"",
                    'invalid_grant' => 'We were unable to sign you in because your request has expired; go back and try again',
                    'temporarily_unavailable' => 'We were unable to sign you in because the servers are busy; try again later',
                    'Only' => $exception->getMessage(),
                    default => 'We were unable to sign you in; try again later',
                },
            );
        }
    }

    public function disconnect(): RedirectResponse
    {
        return MsGraph::disconnect();
    }
}
