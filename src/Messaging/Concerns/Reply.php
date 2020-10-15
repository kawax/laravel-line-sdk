<?php

namespace Revolution\Line\Messaging\Concerns;

use Revolution\Line\Messaging\ReplyMessage;

trait Reply
{
    /**
     * @param  string  $token
     *
     * @return ReplyMessage
     */
    public function reply(string $token)
    {
        return app(ReplyMessage::class, [
            'bot' => $this->bot(),
            'replyToken' => $token,
        ]);
    }
}
