<?php

namespace Revolution\Line\Notifications;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Arr;
use LINE\Clients\MessagingApi\Model\ErrorResponse;
use LINE\Clients\MessagingApi\Model\PushMessageRequest;
use LINE\Clients\MessagingApi\Model\PushMessageResponse;
use Revolution\Line\Facades\Bot;

class LineChannel
{
    public function send(mixed $notifiable, Notification $notification): null|PushMessageResponse|ErrorResponse
    {
        /**
         * @var LineMessage $message
         */
        $message = $notification->toLine($notifiable);

        if (! $message instanceof Arrayable) {
            return null; // @codeCoverageIgnore
        }

        if (! $to = $notifiable->routeNotificationFor('line', $notification)) {
            return null;
        }

        $data = Arr::add($message->toArray(), 'to', $to);

        return Bot::pushMessage(new PushMessageRequest($data));
    }
}
