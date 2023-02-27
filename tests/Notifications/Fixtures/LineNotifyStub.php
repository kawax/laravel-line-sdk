<?php

namespace Tests\Notifications\Fixtures;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Revolution\Line\Notifications\LineNotifyChannel;
use Revolution\Line\Notifications\LineNotifyMessage;

class LineNotifyStub extends Notification
{
    use Queueable;

    /**
     * @var string
     */
    protected string $message;

    /**
     * Create a new notification instance.
     *
     * @param  string  $message
     * @return void
     */
    public function __construct(string $message)
    {
        $this->message = $message;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via(mixed $notifiable): array
    {
        return [
            LineNotifyChannel::class,
        ];
    }

    /**
     * @param  mixed  $notifiable
     * @return LineNotifyMessage
     */
    public function toLineNotify(mixed $notifiable): LineNotifyMessage
    {
        return LineNotifyMessage::create($this->message);
    }
}
