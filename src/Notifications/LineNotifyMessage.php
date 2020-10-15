<?php

namespace Revolution\Line\Notifications;

use Illuminate\Contracts\Support\Arrayable;

class LineNotifyMessage implements Arrayable
{
    /**
     * @var string
     */
    protected $message;

    /**
     * @var int
     */
    protected $stickerPackageId;

    /**
     * @var int
     */
    protected $stickerId;

    /**
     * @var array
     */
    protected $options;

    /**
     * @param  string|null  $message
     */
    public function __construct(string $message = null)
    {
        $this->message = $message;
    }

    /**
     * @param  string  $message
     *
     * @return $this
     */
    public static function create(string $message)
    {
        return new static($message);
    }

    /**
     * @param  string  $message
     *
     * @return $this
     */
    public function message(string $message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * @param  int  $stickerPackageId
     * @param  int  $stickerId
     *
     * @return $this
     */
    public function withSticker(int $stickerPackageId, int $stickerId)
    {
        $this->stickerPackageId = $stickerPackageId;
        $this->stickerId = $stickerId;

        return $this;
    }

    /**
     * Set other options.
     *
     * @param  array  $options
     *
     * @return $this
     */
    public function with(array $options)
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
