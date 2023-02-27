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

    protected LINEBot $bot;

    protected string $token;

    protected ?QuickReplyBuilder $quick = null;

    protected ?SenderBuilder $sender = null;

    public function withBot(LINEBot $bot): static
    {
        $this->bot = $bot;

        return $this;
    }

    public function withToken(string $token): static
    {
        $this->token = $token;

        return $this;
    }

    public function message(MessageBuilder $messageBuilder): ?Response
    {
        return $this->bot->replyMessage($this->token, $messageBuilder);
    }

    public function text(mixed ...$text): ?Response
    {
        $text = collect($text)
            ->push($this->quick, $this->sender)
            ->reject(fn ($item) => blank($item))
            ->toArray();

        return $this->message(new TextMessageBuilder(...$text));
    }

    public function sticker(int|string $package, int|string $id): ?Response
    {
        return $this->message(new StickerMessageBuilder($package, $id, $this->quick, $this->sender));
    }

    public function withQuickReply(QuickReplyBuilder $quickReply): static
    {
        $this->quick = $quickReply;

        return $this;
    }

    public function withSender(string $name = null, string $icon = null): static
    {
        $this->sender = new SenderMessageBuilder($name, $icon);

        return $this;
    }
}
