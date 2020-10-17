<?php

namespace Revolution\Line\Facades;

use Illuminate\Support\Facades\Facade;
use Revolution\Line\Contracts\NotifyFactory;

/**
 * @method static $this withToken(string $token)
 * @method array notify(array $params)
 * @method array status()
 * @method array revoke()
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
