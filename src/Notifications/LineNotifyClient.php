<?php

namespace Revolution\Line\Notifications;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Utils;
use Illuminate\Support\Traits\Macroable;
use Revolution\Line\Contracts\NotifyFactory;

class LineNotifyClient implements NotifyFactory
{
    use Macroable;

    protected const ENDPOINT = 'https://notify-api.line.me/api/';

    /**
     * @var ClientInterface
     */
    protected $http;

    /**
     * @var string
     */
    protected $token;

    /**
     * @param  ClientInterface  $http
     */
    public function __construct(ClientInterface $http)
    {
        $this->http = $http;
    }

    /**
     * @param  string  $token
     * @return $this
     */
    public function withToken(string $token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * @param  array  $params
     * @return array
     *
     * @throws GuzzleException
     */
    public function notify(array $params)
    {
        $request = new Request(
            'POST',
            self::ENDPOINT.'notify',
            [
                'Content-Type' => 'application/x-www-form-urlencoded',
                'Authorization' => 'Bearer '.$this->token,
            ],
            Utils::streamFor(http_build_query($params))
        );

        $response = $this->http->send($request);

        return json_decode($response->getBody(), true);
    }

    /**
     * @return array
     *
     * @throws GuzzleException
     */
    public function status()
    {
        $request = new Request(
            'GET',
            self::ENDPOINT.'status',
            [
                'Authorization' => 'Bearer '.$this->token,
            ]
        );

        $response = $this->http->send($request);

        return json_decode($response->getBody(), true);
    }

    /**
     * @return array
     *
     * @throws GuzzleException
     */
    public function revoke()
    {
        $request = new Request(
            'POST',
            self::ENDPOINT.'revoke',
            [
                'Content-Type' => 'application/x-www-form-urlencoded',
                'Authorization' => 'Bearer '.$this->token,
            ]
        );

        $response = $this->http->send($request);

        return json_decode($response->getBody(), true);
    }
}
