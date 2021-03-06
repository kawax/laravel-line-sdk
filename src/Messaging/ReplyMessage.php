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
     * @return $this
     */
    public function withBot($bot)
    {
        $this->bot = $bot;

        return $this;
    }

    /**
     * @param  string  $token
     * @return $this
     */
    public function withToken(string $token)
    {
        $this->token = $token;

        return $this;
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
     * @param  string|int  $packageId
     * @param  string|int  $stickerId
     * @return Response
     */
    public function sticker($packageId, $stickerId)
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
     * @param  string|null  $icon
     * @return $this
     */
    public function withSender(string $name = null, string $icon = null)
    {
        $this->sender = new SenderMessageBuilder($name, $icon);

        return $this;
    }
}
