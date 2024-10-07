<?php

namespace Revolution\Line\Facades;

use Illuminate\Support\Facades\Facade;
use Revolution\Line\Contracts\NotifyFactory;

/**
 * @method static static withToken(string $token)
 * @method array notify(array $params)
 * @method array status()
 * @method array revoke()
 *
 * @deprecated
 */
class LineNotify extends Facade
{
    /**
     * Get the registered name of the component.
     */
    protected static function getFacadeAccessor(): string
    {
        return NotifyFactory::class;
    }
}
