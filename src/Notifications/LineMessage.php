<?php

namespace Revolution\Line\Notifications;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Traits\Conditionable;
use Illuminate\Support\Traits\Macroable;
use LINE\Clients\MessagingApi\Model\ImageMessage;
use LINE\Clients\MessagingApi\Model\Message;
use LINE\Clients\MessagingApi\Model\StickerMessage;
use LINE\Clients\MessagingApi\Model\TextMessage;
use LINE\Clients\MessagingApi\Model\VideoMessage;
use LINE\Constants\MessageType;

final class LineMessage implements Arrayable
{
    use Conditionable;
    use Macroable;

    protected array $messages = [];

    protected array $options = [];

    public static function create(?string $text = null): self
    {
        return (new self())->unless(empty($text), fn (self $message) => $message->text($text));
    }

    /**
     * Add TextMessage.
     */
    public function text(string $text): self
    {
        return $this->message(
            (new TextMessage())
                ->setType(MessageType::TEXT)
                ->setText($text)
        );
    }

    /**
     * Add StickerMessage.
     */
    public function sticker(int $package, int $sticker): self
    {
        return $this->message(
            (new StickerMessage())
                ->setType(MessageType::STICKER)
                ->setPackageId($package)
                ->setStickerId($sticker)
        );
    }

    /**
     * Add ImageMessage.
     */
    public function image(string $original, string $preview): self
    {
        return $this->message(
            (new ImageMessage())
                ->setType(MessageType::IMAGE)
                ->setOriginalContentUrl($original)
                ->setPreviewImageUrl($preview)
        );
    }

    /**
     * Add VideoMessage.
     */
    public function video(string $original, string $preview): self
    {
        return $this->message(
            (new VideoMessage())
                ->setType(MessageType::VIDEO)
                ->setOriginalContentUrl($original)
                ->setPreviewImageUrl($preview)
        );
    }

    /**
     * Add any Message object.
     */
    public function message(Message $message): self
    {
        $this->messages[] = $message;

        return $this;
    }

    /**
     * Set other options.
     */
    public function with(array $options): self
    {
        $this->options = $options;

        return $this;
    }

    public function toArray(): array
    {
        return array_merge(
            ['messages' => collect($this->messages)->take(5)->all()],
            $this->options
        );
    }
}
