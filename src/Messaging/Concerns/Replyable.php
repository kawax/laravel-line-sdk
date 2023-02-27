<?php

namespace Revolution\Line\Messaging\Concerns;

use LINE\LINEBot;
use Revolution\Line\Messaging\ReplyMessage;

trait Replyable
{
    public function reply(string $token): ReplyMessage
    {
        return app(ReplyMessage::class)
            ->withBot($this->bot())
            ->withToken($token);
    }

    abstract public function bot(): LINEBot;
}
