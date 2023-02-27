<?php

namespace Revolution\Line\Notifications;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Client\RequestException;
use Illuminate\Notifications\Notification;
use Revolution\Line\Contracts\NotifyFactory;

class LineNotifyChannel
{
    public function __construct(
        protected NotifyFactory $notify
    ) {
        //
    }

    /**
     * @throws RequestException
     */
    public function send(mixed $notifiable, Notification $notification): void
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
