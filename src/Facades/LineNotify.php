<?php

namespace Revolution\Line\Facades;

use Illuminate\Support\Facades\Facade;
use Revolution\Line\Contracts\NotifyFactory;

/**
 * @method static array notify(string $token, array $params)
 * @method static array status(string $token)
 * @method static array revoke(string $token)
 */
class LineNotify extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return NotifyFactory::class;
    }
}
