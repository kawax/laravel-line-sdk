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
    protected LINEBot $bot;

    /**
     * @var string
     */
    protected string $token;

    /**
     * @var QuickReplyBuilder|null
     */
    protected ?QuickReplyBuilder $quick = null;

    /**
     * @var SenderBuilder|null
     */
    protected ?SenderBuilder $sender = null;

    /**
     * @param  LINEBot  $bot
     * @return $this
     */
    public function withBot(LINEBot $bot): self
    {
        $this->bot = $bot;

        return $this;
    }

    /**
     * @param  string  $token
     * @return $this
     */
    public function withToken(string $token): self
    {
        $this->token = $token;

        return $this;
    }

    /**
     * @param  MessageBuilder  $messageBuilder
     * @return Response|null
     */
    public function message(MessageBuilder $messageBuilder): ?Response
    {
        return $this->bot->replyMessage($this->token, $messageBuilder);
    }

    /**
     * @param  mixed  ...$text
     * @return Response|null
     */
    public function text(...$text): ?Response
    {
        $text = collect($text)
            ->push($this->quick, $this->sender)
            ->reject(fn($item) => blank($item))
            ->toArray();

        return $this->message(new TextMessageBuilder(...$text));
    }

    /**
     * @param  int|string  $packageId
     * @param  int|string  $stickerId
     * @return Response|null
     */
    public function sticker(int|string $packageId, int|string $stickerId): ?Response
    {
        return $this->message(new StickerMessageBuilder($packageId, $stickerId, $this->quick, $this->sender));
    }

    /**
     * @param  QuickReplyBuilder  $quickReply
     * @return $this
     */
    public function withQuickReply(QuickReplyBuilder $quickReply): self
    {
        $this->quick = $quickReply;

        return $this;
    }

    /**
     * @param  string|null  $name
     * @param  string|null  $icon
     * @return $this
     */
    public function withSender(string $name = null, string $icon = null): self
    {
        $this->sender = new SenderMessageBuilder($name, $icon);

        return $this;
    }
}
