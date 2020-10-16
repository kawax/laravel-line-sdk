<?php

namespace Revolution\Line\Notifications;

use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Traits\Macroable;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Revolution\Line\Contracts\NotifyFactory;
use GuzzleHttp\Psr7\Utils;

class LineNotifyClient implements NotifyFactory
{
    use Macroable;

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
     * @param  array  $params
     * @return array
     * @throws ClientExceptionInterface
     */
    public function notify(string $token, array $params): array
    {
        $headers = [
            'Content-Type' => 'application/x-www-form-urlencoded',
            'Authorization' => 'Bearer '.$token,
        ];

        $request = new Request(
            'POST',
            self::ENDPOINT.'notify',
            $headers,
            Utils::streamFor(http_build_query($params))
        );

        $response = $this->http->sendRequest($request);

        return json_decode($response->getBody(), true);
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
