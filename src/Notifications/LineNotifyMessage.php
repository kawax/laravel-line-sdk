<?php

namespace Revolution\Line\Notifications;

use Illuminate\Contracts\Support\Arrayable;
use JetBrains\PhpStorm\Pure;

class LineNotifyMessage implements Arrayable
{
    public function __construct(
        protected ?string $message = null,
        protected ?int $stickerPackageId = null,
        protected ?int $stickerId = null,
        protected array $options = []
    ) {
        //
    }

    /**
     * @param  string  $message
     * @return $this
     */
    #[Pure]
    public static function create(string $message): self
    {
        return new static($message);
    }

    /**
     * @param  string  $message
     * @return $this
     */
    public function message(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    /**
     * @param  int  $stickerPackageId
     * @param  int  $stickerId
     * @return $this
     */
    public function withSticker(int $stickerPackageId, int $stickerId): self
    {
        $this->stickerPackageId = $stickerPackageId;
        $this->stickerId = $stickerId;

        return $this;
    }

    /**
     * Set other options.
     *
     * @param  array  $options
     * @return $this
     */
    public function with(array $options): self
    {
        $this->options = $options;

        return $this;
    }

    /**
     * @return array
     */
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
