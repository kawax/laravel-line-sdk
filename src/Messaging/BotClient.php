<?php

namespace Revolution\Line\Messaging;

use Illuminate\Support\Traits\Macroable;
use LINE\LINEBot;
use Revolution\Line\Contracts\BotFactory;
use Revolution\Line\Messaging\Concerns\EventParser;
use Revolution\Line\Messaging\Concerns\Replyable;

class BotClient implements BotFactory
{
    use EventParser;
    use Replyable;
    use Macroable {
        __call as macroCall;
    }

    /**
     * @var LINEBot
     */
    protected $bot;

    /**
     * BotClient constructor.
     *
     * @param  LINEBot  $bot
     */
    public function __construct(LINEBot $bot)
    {
        $this->bot = $bot;
    }

    /**
     * @return LINEBot
     */
    public function bot()
    {
        return $this->bot;
    }

    /**
     * @param  LINEBot|callable  $bot
     *
     * @return $this
     */
    public function botUsing($bot)
    {
        $this->bot = is_callable($bot) ? call_user_func($bot) : $bot;

        return $this;
    }

    /**
     * Magic call method.
     *
     * @param  string  $method
     * @param  array  $parameters
     *
     * @return mixed
     * @throws \BadMethodCallException
     */
    public function __call($method, $parameters)
    {
        if (method_exists($this->bot(), $method)) {
            return call_user_func_array([$this->bot(), $method], $parameters);
        }

        return $this->macroCall($method, $parameters);
    }
}
