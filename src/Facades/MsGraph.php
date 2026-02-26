<?php

namespace NetworkRailBusinessSystems\Entra\Facades;

use Dcblogdev\MsGraph\Facades\MsGraph as BaseMsGraph;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

/**
 * This helper exists to document the methods of the base MsGraph facade
 *
 * @method static Redirector|RedirectResponse connect(?string $id = null)
 * @method static array delete(string $path, array $data = [], array $headers = [], int|string|null $id = null)
 * @method static RedirectResponse disconnect(string $redirectPath = '/', bool $logout = true)
 * @method static array get(string $path, array $data = [], array $headers = [], int|string|null $id = null)
 * @method static array patch(string $path, array $data = [], array $headers = [], int|string|null $id = null)
 * @method static array post(string $path, array $data = [], array $headers = [], int|string|null $id = null)
 * @method static array put(string $path, array $data = [], array $headers = [], int|string|null $id = null)
 *
 * @mixin \Dcblogdev\MsGraph\MsGraph
 * @see \Dcblogdev\MsGraph\MsGraph
 */
class MsGraph extends BaseMsGraph
{
    //
}
