<?php

namespace Revolution\Line\Contracts;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use LINE\LINEBot;
use Revolution\Line\Messaging\ReplyMessage;

interface BotFactory
{
    public function bot(): LINEBot;

    public function botUsing(callable|LINEBot $bot): static;

    public function reply(string $token): ReplyMessage;

    public function parseEvent(Request $request): Collection;
}
