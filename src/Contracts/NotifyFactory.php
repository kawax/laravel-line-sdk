<?php

namespace Revolution\Line\Contracts;

use Psr\Http\Client\ClientExceptionInterface;

interface NotifyFactory
{
    /**
     * @param  string  $token
     *
     * @return $this
     */
    public function withToken(string $token);

    /**
     * @param  array  $params
     * @return array
     * @throws ClientExceptionInterface
     */
    public function notify(array $params);

    /**
     * @return array
     * @throws ClientExceptionInterface
     */
    public function status();

    /**
     * @return array
     * @throws ClientExceptionInterface
     */
    public function revoke();
}
