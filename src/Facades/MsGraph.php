<?php

namespace NetworkRailBusinessSystems\Entra\Facades;

use Dcblogdev\MsGraph\Facades\MsGraph as BaseMsGraph;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use stdClass;

/**
 * This helper exists to document the methods of the base MsGraph facade
 *
 * @method static Redirector|RedirectResponse connect(?string $id = null)
 * @method static array|stdClass delete(string $path, array $data = [], array $headers = [], int|string|null $id = null)
 * @method static RedirectResponse disconnect(string $redirectPath = '/', bool $logout = true)
 * @method static array|stdClass get(string $path, array $data = [], array $headers = [], int|string|null $id = null)
 * @method static array|stdClass patch(string $path, array $data = [], array $headers = [], int|string|null $id = null)
 * @method static array|stdClass post(string $path, array $data = [], array $headers = [], int|string|null $id = null)
 * @method static array|stdClass put(string $path, array $data = [], array $headers = [], int|string|null $id = null)
 *
 * @mixin \Dcblogdev\MsGraph\MsGraph
 * @see \Dcblogdev\MsGraph\MsGraph
 */
class MsGraph extends BaseMsGraph
{
    //
}
