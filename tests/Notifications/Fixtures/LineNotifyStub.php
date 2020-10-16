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
    protected $message;

    /**
     * Create a new notification instance.
     *
     * @param  string  $message
     *
     * @return void
     */
    public function __construct($message)
    {
        $this->message = $message;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [
            LineNotifyChannel::class,
        ];
    }

    /**
     * @param  mixed  $notifiable
     * @return LineNotifyMessage
     */
    public function toLineNotify($notifiable)
    {
        return LineNotifyMessage::create($this->message);
    }
}
