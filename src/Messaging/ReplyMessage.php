<?php

namespace Revolution\Line\Messaging;

use Illuminate\Support\Traits\Macroable;
use LINE\Clients\MessagingApi\Api\MessagingApiApi;
use LINE\Clients\MessagingApi\ApiException;
use LINE\Clients\MessagingApi\Model\Message;
use LINE\Clients\MessagingApi\Model\QuickReply;
use LINE\Clients\MessagingApi\Model\ReplyMessageRequest;
use LINE\Clients\MessagingApi\Model\Sender;
use LINE\Clients\MessagingApi\Model\StickerMessage;
use LINE\Clients\MessagingApi\Model\TextMessage;
use LINE\Constants\MessageType;

final class ReplyMessage
{
    use Macroable;

    protected MessagingApiApi $bot;

    protected string $token;

    protected ?QuickReply $quick = null;

    protected ?Sender $sender = null;

    public function withBot(MessagingApiApi $bot): self
    {
        $this->bot = $bot;

        return $this;
    }

    public function withToken(string $token): self
    {
        $this->token = $token;

        return $this;
    }

    /**
     * @throws ApiException
     */
    public function message(Message ...$messages): void
    {
        $reply = new ReplyMessageRequest([
            'replyToken' => $this->token,
            'messages' => $messages,
        ]);

        $this->bot->replyMessage($reply);
    }

    /**
     * @throws ApiException
     */
    public function text(mixed ...$text): void
    {
        $messages = collect($text)
            ->reject(fn ($item) => blank($item))
            ->map(function ($item) {
                $text = (new TextMessage(['text' => $item]))->setType(MessageType::TEXT);
                if (filled($this->quick)) {
                    $text->setQuickReply($this->quick);
                }
                if (filled($this->sender)) {
                    $text->setSender($this->sender);
                }

                return $text;
            })
            ->toArray();

        $this->message(...$messages);
    }

    /**
     * @throws ApiException
     */
    public function sticker(int|string $package, int|string $sticker): void
    {
        $message = new StickerMessage([
            'type' => MessageType::STICKER,
            'packageId' => $package,
            'stickerId' => $sticker,
        ]);

        $this->message($message);
    }

    public function withQuickReply(QuickReply $quickReply): self
    {
        $this->quick = $quickReply;

        return $this;
    }

    public function withSender(?string $name = null, ?string $icon = null): self
    {
        $this->sender = new Sender(['name' => $name, 'iconUrl' => $icon]);

        return $this;
    }
}
