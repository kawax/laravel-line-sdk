<?php

namespace Revolution\Line\Notifications;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Traits\Conditionable;
use Illuminate\Support\Traits\Macroable;

/**
 * @deprecated
 */
final class LineNotifyMessage implements Arrayable
{
    use Conditionable;
    use Macroable;

    public function __construct(
        protected ?string $message = null,
        protected ?int $stickerPackageId = null,
        protected ?int $stickerId = null,
        protected array $options = []
    ) {
        //
    }

    public static function create(string $message): self
    {
        return new self($message);
    }

    public function message(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function withSticker(int $package, int $id): self
    {
        $this->stickerPackageId = $package;
        $this->stickerId = $id;

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
            [
                'message' => $this->message,
                'stickerPackageId' => $this->stickerPackageId,
                'stickerId' => $this->stickerId,
            ],
            $this->options ?? []
        );
    }
}
