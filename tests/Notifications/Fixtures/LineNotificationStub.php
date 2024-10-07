<?php

namespace Tests\Notifications\Fixtures;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Revolution\Line\Notifications\LineChannel;
use Revolution\Line\Notifications\LineMessage;

class LineNotificationStub extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(protected string $text)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via(mixed $notifiable): array
    {
        return [
            LineChannel::class,
        ];
    }

    public function toLine(mixed $notifiable): LineMessage
    {
        return LineMessage::create()->text($this->text);
    }
}
