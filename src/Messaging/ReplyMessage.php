<?php

namespace Revolution\Line\Messaging;

use LINE\LINEBot;
use LINE\LINEBot\MessageBuilder;
use LINE\LINEBot\MessageBuilder\TextMessageBuilder;
use LINE\LINEBot\Response;

class ReplyMessage
{
    /**
     * @var LINEBot
     */
    protected $bot;

    /**
     * @var string
     */
    protected $token;

    /**
     * @param  LINEBot  $bot
     * @param  string  $token
     */
    public function __construct($bot, string $token)
    {
        $this->bot = $bot;
        $this->token = $token;
    }

    /**
     * @param  MessageBuilder  $messageBuilder
     * @return Response
     */
    public function message(MessageBuilder $messageBuilder)
    {
        return $this->bot->replyMessage($this->token, $messageBuilder);
    }

    /**
     * @param  mixed  ...$text
     * @return Response
     */
    public function text(...$text)
    {
        return $this->message(new TextMessageBuilder(...$text));
    }
}
