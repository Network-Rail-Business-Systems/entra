<?php

namespace NetworkRailBusinessSystems\Entra\Facades;

use Dcblogdev\MsGraph\Facades\MsGraph as BaseMsGraph;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use stdClass;

/**
 * This helper exists to document the methods of the base MsGraph facade
 *
 * @method static array|stdClass delete(string $path, array $data = [], array $headers = [], int|string|null $id = null)
 * @method static RedirectResponse disconnect(string $redirectPath = '/', bool $logout = true)
 * @method static array|stdClass get(string $path, array $data = [], array $headers = [], int|string|null $id = null)
 * @method static bool isConnected(?string $id = null)
 * @method static array|stdClass patch(string $path, array $data = [], array $headers = [], int|string|null $id = null)
 * @method static array|stdClass post(string $path, array $data = [], array $headers = [], int|string|null $id = null)
 * @method static array|stdClass put(string $path, array $data = [], array $headers = [], int|string|null $id = null)
 *
 * @mixin \Dcblogdev\MsGraph\MsGraph
 * @see \Dcblogdev\MsGraph\MsGraph
 */
class MsGraph extends BaseMsGraph
{
    public static function connect(?string $id = null): RedirectResponse
    {
        if (str_ends_with(URL::current(), 'entra/connect') === true) {
            if (request()->has('code') === false) {
                Session::flash('url.intended', URL::previous());
            }
        } else {
            Session::flash('url.intended', URL::current());
        }

        /** @var RedirectResponse $redirect */
        $redirect = BaseMsGraph::connect($id);

        return str_starts_with(
            $redirect->getTargetUrl(),
            config('msgraph.urlAuthorize'),
        ) === true
            ? $redirect
            : Redirect::intended();
    }
}
