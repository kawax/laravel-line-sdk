<?php

namespace Revolution\Line\Messaging\Concerns;

use Revolution\Line\Messaging\ReplyMessage;

trait Reply
{
    /**
     * @param  string  $token
     * @return ReplyMessage
     */
    public function reply(string $token)
    {
        return new ReplyMessage($this->bot(), $token);
    }
}
