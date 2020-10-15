<?php

namespace Revolution\Line\Messaging\Concerns;

use Revolution\Line\Messaging\ReplyMessage;

trait Reply
{
    /**
     * @param  string  $replyToken
     * @return ReplyMessage
     */
    public function reply(string $replyToken)
    {
        return new ReplyMessage($this->bot(), $replyToken);
    }
}
