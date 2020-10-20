<?php

namespace Revolution\Line\Contracts;

use GuzzleHttp\Exception\GuzzleException;

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
     * @throws GuzzleException
     */
    public function notify(array $params);

    /**
     * @return array
     * @throws GuzzleException
     */
    public function status();

    /**
     * @return array
     * @throws GuzzleException
     */
    public function revoke();
}
