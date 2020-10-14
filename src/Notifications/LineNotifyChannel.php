<?php

namespace Revolution\Line\Notifications;

use GuzzleHttp\Client;
use Illuminate\Notifications\Notification;

class LineNotifyChannel
{
    /**
     * @var Client
     */
    protected $http;

    /**
     * @param  Client  $client
     */
    public function __construct(Client $client)
    {
        $this->http = $client;
    }

    /**
     * @param  mixed  $notifiable
     * @param  Notification  $notification
     *
     * @return \Psr\Http\Message\ResponseInterface|null|void
     */
    public function send($notifiable, Notification $notification)
    {
        /**
         * @var LineNotifyMessage $message
         */
        $message = $notification->toLineNotify($notifiable);

        if (! $token = $notifiable->routeNotificationFor('line-notify', $notification)) {
            return;
        }

        $headers = [
            'Content-Type' => 'application/x-www-form-urlencoded',
            'Authorization' => 'Bearer '.$token,
        ];

        $form_params = $message->toArray();

        return $this->http->post(
            'https://notify-api.line.me/api/notify',
            compact('headers', 'form_params')
        );
    }
}
