<?php

namespace NetworkRailBusinessSystems\Entra;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use ErrorException;
use NetworkRailBusinessSystems\Entra\Facades\MsGraph;
use Throwable;

class EntraController extends Controller
{
    public function connect(): RedirectResponse
    {
        if (request()->has('code') === false) {
            Session::flash(
                'url.intended',
                URL::previous(),
            );
        }

        try {
            return MsGraph::connect();
        } catch (HttpResponseException $exception) {
            throw $exception;
        } catch (Throwable $exception) {
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
                    'only_existing' => config('entra.messages.only_existing'),
                    default => 'We were unable to sign you in; try again later',
                },
            );
        }
    }

    public function disconnect(): RedirectResponse
    {
        return MsGraph::disconnect();
    }

    public function intended(): RedirectResponse
    {
        return Redirect::intended();
    }
}
