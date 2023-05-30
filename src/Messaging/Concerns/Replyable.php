<?php

namespace Revolution\Line\Messaging\Concerns;

use LINE\Clients\MessagingApi\Api\MessagingApiApi;
use Revolution\Line\Messaging\ReplyMessage;

trait Replyable
{
    public function reply(string $token): ReplyMessage
    {
        return app(ReplyMessage::class)
            ->withBot($this->bot())
            ->withToken($token);
    }

    abstract public function bot(): MessagingApiApi;
}
