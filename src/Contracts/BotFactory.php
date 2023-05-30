<?php

namespace Revolution\Line\Contracts;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use LINE\Clients\MessagingApi\Api\MessagingApiApi;
use Revolution\Line\Messaging\ReplyMessage;

interface BotFactory
{
    public function bot(): MessagingApiApi;

    public function botUsing(callable|MessagingApiApi $bot): static;

    public function reply(string $token): ReplyMessage;

    public function parseEvent(Request $request): Collection;
}
