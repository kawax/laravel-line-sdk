<?php

namespace Revolution\Line\Contracts;

interface NotifyFactory
{
    /**
     * @param  string  $token
     * @return array
     */
    public function status(string $token): array;

    /**
     * @param  string  $token
     * @return array
     */
    public function revoke(string $token): array;
}
