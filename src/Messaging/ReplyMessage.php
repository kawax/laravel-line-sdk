<?php

namespace Revolution\Line\Messaging;

use Illuminate\Support\Traits\Macroable;
use LINE\LINEBot;
use LINE\LINEBot\MessageBuilder;
use LINE\LINEBot\MessageBuilder\StickerMessageBuilder;
use LINE\LINEBot\MessageBuilder\TextMessageBuilder;
use LINE\LINEBot\QuickReplyBuilder;
use LINE\LINEBot\Response;
use LINE\LINEBot\SenderBuilder\SenderBuilder;
use LINE\LINEBot\SenderBuilder\SenderMessageBuilder;

class ReplyMessage
{
    use Macroable;

    /**
     * @var LINEBot
     */
    protected $bot;

    /**
     * @var string
     */
    protected $token;

    /**
     * @var QuickReplyBuilder
     */
    protected $quick;

    /**
     * @var SenderBuilder
     */
    protected $sender;

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
        $text = collect($text)
            ->push($this->quick, $this->sender)
            ->reject(function ($item) {
                return blank($item);
            })->toArray();

        return $this->message(new TextMessageBuilder(...$text));
    }

    /**
     * @param  int  $packageId
     * @param  int  $stickerId
     * @return Response
     */
    public function sticker(int $packageId, int $stickerId)
    {
        return $this->message(new StickerMessageBuilder($packageId, $stickerId, $this->quick, $this->sender));
    }

    /**
     * @param  QuickReplyBuilder  $quickReply
     * @return $this
     */
    public function withQuickReply(QuickReplyBuilder $quickReply)
    {
        $this->quick = $quickReply;

        return $this;
    }

    /**
     * @param  string|null  $name
     * @param  string|null  $iconUrl
     * @return $this
     */
    public function withSender(string $name = null, string $iconUrl = null)
    {
        $this->sender = new SenderMessageBuilder($name, $iconUrl);

        return $this;
    }
}
