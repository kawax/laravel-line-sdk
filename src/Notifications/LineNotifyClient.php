<?php

namespace Revolution\Line\Notifications;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Request;
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
     * @param  ClientInterface  $client
     */
    public function __construct(ClientInterface $client)
    {
        $this->http = $client;
    }

    /**
     * @param  string  $token
     * @return array
     * @throws GuzzleException
     */
    public function status(string $token): array
    {
        $headers = [
            'Authorization' => 'Bearer '.$token,
        ];

        $response = $this->http->sendRequest(new Request(
            'GET',
            self::ENDPOINT.'status',
            $headers
        ));

        return json_decode($response->getBody(), true);
    }

    /**
     * @param  string  $token
     * @return array
     * @throws GuzzleException
     */
    public function revoke(string $token): array
    {
        $headers = [
            'Content-Type' => 'application/x-www-form-urlencoded',
            'Authorization' => 'Bearer '.$token,
        ];

        $response = $this->http->sendRequest(new Request(
            'POST',
            self::ENDPOINT.'revoke',
            $headers
        ));

        return json_decode($response->getBody(), true);
    }
}
