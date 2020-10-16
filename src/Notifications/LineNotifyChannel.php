<?php

namespace Revolution\Line\Notifications;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Notifications\Notification;
use Revolution\Line\Contracts\NotifyFactory;

class LineNotifyChannel
{
    /**
     * @var NotifyFactory
     */
    protected $notify;

    /**
     * @param  NotifyFactory  $notify
     */
    public function __construct(NotifyFactory $notify)
    {
        $this->notify = $notify;
    }

    /**
     * @param  mixed  $notifiable
     * @param  Notification  $notification
     *
     * @return void
     */
    public function send($notifiable, Notification $notification)
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

        $this->notify->notify(
            $token,
            $message->toArray()
        );
    }
}
