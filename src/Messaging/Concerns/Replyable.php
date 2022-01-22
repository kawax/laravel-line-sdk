<?php

namespace Revolution\Line\Messaging\Concerns;

use LINE\LINEBot;
use Revolution\Line\Messaging\ReplyMessage;

trait Replyable
{
    /**
     * @param  string  $token
     * @return ReplyMessage
     */
    public function reply(string $token): ReplyMessage
    {
        return app(ReplyMessage::class)
            ->withBot($this->bot())
            ->withToken($token);
    }

    /**
     * @return LINEBot
     */
    abstract public function bot(): LINEBot;
}
