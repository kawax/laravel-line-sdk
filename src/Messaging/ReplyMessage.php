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
    protected $replyToken;

    /**
     * @param  LINEBot  $bot
     * @param  string  $replyToken
     */
    public function __construct(LINEBot $bot, string $replyToken)
    {
        $this->bot = $bot;
        $this->replyToken = $replyToken;
    }

    /**
     * @param  MessageBuilder  $messageBuilder
     * @return Response
     */
    public function message(MessageBuilder $messageBuilder)
    {
        return $this->bot->replyMessage($this->replyToken, $messageBuilder);
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
