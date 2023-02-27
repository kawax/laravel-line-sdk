<?php

namespace Revolution\Line\Messaging\Http\Controllers;

use Illuminate\Http\Request;
use Revolution\Line\Contracts\WebhookHandler;

class WebhookController
{
    public function __invoke(WebhookHandler $handler, Request $request): mixed
    {
        return $handler($request);
    }
}
