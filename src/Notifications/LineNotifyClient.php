<?php

namespace Revolution\Line\Notifications;

use GuzzleHttp\Psr7\Request;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Revolution\Line\Contracts\NotifyFactory;

class LineNotifyClient implements NotifyFactory
{
    protected const ENDPOINT = 'https://notify-api.line.me/api/';

    /**
     * @var ClientInterface
     */
    protected $http;

    /**
     * @param  ClientInterface  $http
     */
    public function __construct(ClientInterface $http)
    {
        $this->http = $http;
    }

    /**
     * @param  string  $token
     * @return array
     * @throws ClientExceptionInterface
     */
    public function status(string $token): array
    {
        $request = new Request(
            'GET',
            self::ENDPOINT.'status',
            [
                'Authorization' => 'Bearer '.$token,
            ]
        );

        $response = $this->http->sendRequest($request);

        return json_decode($response->getBody(), true);
    }

    /**
     * @param  string  $token
     * @return array
     * @throws ClientExceptionInterface
     */
    public function revoke(string $token): array
    {
        $request = new Request(
            'GET',
            self::ENDPOINT.'revoke',
            [
                'Content-Type' => 'application/x-www-form-urlencoded',
                'Authorization' => 'Bearer '.$token,
            ]
        );

        $response = $this->http->sendRequest($request);

        return json_decode($response->getBody(), true);
    }
}
