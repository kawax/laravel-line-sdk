<?php

namespace Revolution\Line\Contracts;

use LINE\LINEBot;

interface BotFactory
{
    /**
     * @return LINEBot
     */
    public function bot();

    /**
     * @param  LINEBot|callable  $bot
     *
     * @return $this
     */
    public function botUsing($bot);
}
