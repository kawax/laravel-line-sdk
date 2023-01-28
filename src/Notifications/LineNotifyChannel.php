<?php

namespace Revolution\Line\Notifications;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Notifications\Notification;
use Psr\Http\Client\ClientExceptionInterface;
use Revolution\Line\Contracts\NotifyFactory;

class LineNotifyChannel
{
    /**
     * @param  NotifyFactory  $notify
     */
    public function __construct(protected NotifyFactory $notify)
    {
        //
    }

    /**
     * @param  mixed  $notifiable
     * @param  Notification  $notification
     * @return void
     *
     * @throws ClientExceptionInterface
     */
    public function send($notifiable, Notification $notification): void
    {
        /**
         * @var LineNotifyMessage $message
         */
        $message = $notification->toLineNotify($notifiable);

        if (! $message instanceof Arrayable) {
            return;
        }

        if (! $token = $notifiable->routeNotificationFor('line-notify', $notification)) {
            return;
        }

        $this->notify->withToken($token)->notify($message->toArray());
    }
}
