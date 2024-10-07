<?php

namespace Revolution\Line\Notifications;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Client\RequestException;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Arr;
use LINE\Clients\MessagingApi\Model\PushMessageRequest;
use Revolution\Line\Contracts\NotifyFactory;
use Revolution\Line\Facades\Bot;

class LineChannel
{
    public function send(mixed $notifiable, Notification $notification): void
    {
        /**
         * @var LineMessage $message
         */
        $message = $notification->toLine($notifiable);

        if (! $message instanceof Arrayable) {
            return; // @codeCoverageIgnore
        }

        if (! $to = $notifiable->routeNotificationFor('line', $notification)) {
            return;
        }

        $data = Arr::add($message->toArray(), 'to', $to);

        Bot::pushMessage(new PushMessageRequest($data));
    }
}
