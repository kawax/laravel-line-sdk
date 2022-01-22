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
    public function bot(): LINEBot;

    /**
     * @param  callable|LINEBot  $bot
     * @return $this
     */
    public function botUsing(callable|LINEBot $bot): self;

    /**
     * @param  string  $token
     * @return ReplyMessage
     */
    public function reply(string $token): ReplyMessage;

    /**
     * @param  Request  $request
     * @return Collection
     */
    public function parseEvent(Request $request): Collection;
}
