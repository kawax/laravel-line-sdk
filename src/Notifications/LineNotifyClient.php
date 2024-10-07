<?php

namespace Revolution\Line\Notifications;

use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Traits\Macroable;
use Revolution\Line\Contracts\NotifyFactory;

/**
 * @deprecated
 */
class LineNotifyClient implements NotifyFactory
{
    use Macroable;

    protected const ENDPOINT = 'https://notify-api.line.me/api/';

    protected string $token;

    public function withToken(string $token): self
    {
        $this->token = $token;

        return $this;
    }

    /**
     * @throws RequestException
     */
    public function notify(array $params): array
    {
        return Http::baseUrl(self::ENDPOINT)
            ->asForm()
            ->withToken($this->token)
            ->post('notify', $params)
            ->throw()
            ->json();
    }

    /**
     * @throws RequestException
     */
    public function status(): array
    {
        return Http::baseUrl(self::ENDPOINT)
            ->asForm()
            ->withToken($this->token)
            ->get('status')
            ->throw()
            ->json();
    }

    /**
     * @throws RequestException
     */
    public function revoke(): array
    {
        return Http::baseUrl(self::ENDPOINT)
            ->asForm()
            ->withToken($this->token)
            ->post('revoke')
            ->throw()
            ->json();
    }
}
