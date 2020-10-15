<?php

namespace Revolution\Line\Contracts;

use GuzzleHttp\Exception\GuzzleException;

interface NotifyFactory
{
    /**
     * @param  string  $token
     * @return array
     * @throws GuzzleException
     */
    public function status(string $token): array;

    /**
     * @param  string  $token
     * @return array
     * @throws GuzzleException
     */
    public function revoke(string $token): array;
}
