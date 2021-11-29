<?php

namespace Revolution\Line\Contracts;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use LINE\LINEBot;
use Revolution\Line\Messaging\ReplyMessage;

interface BotFactory
{
    /**
     * @return LINEBot
     */
    public function bot();

    /**
     * @param  LINEBot|callable  $bot
     * @return $this
     */
    public function botUsing($bot);

    /**
     * @param  string  $token
     * @return ReplyMessage
     */
    public function reply(string $token);

    /**
     * @param  Request  $request
     * @return Collection
     */
    public function parseEvent(Request $request);
}
