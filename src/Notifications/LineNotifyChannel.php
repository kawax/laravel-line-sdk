<?php

namespace Revolution\Line\Notifications;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Notifications\Notification;

class LineNotifyChannel
{
    /**
     * @var string
     */
    protected $endpoint = 'https://notify-api.line.me/api/notify';

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
     * @return void
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

        try {
            $response = $this->http->post(
                $this->endpoint,
                compact('headers', 'form_params')
            );
        } catch (GuzzleException $e) {
            report($e);
        }
    }
}
