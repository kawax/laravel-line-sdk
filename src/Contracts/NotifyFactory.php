<?php

namespace Revolution\Line\Contracts;

use Illuminate\Http\Client\RequestException;

interface NotifyFactory
{
    public function withToken(string $token): self;

    /**
     * @throws RequestException
     */
    public function notify(array $params): array;

    /**
     * @throws RequestException
     */
    public function status(): array;

    /**
     * @throws RequestException
     */
    public function revoke(): array;
}
