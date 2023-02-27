<?php

namespace Revolution\Line\Messaging\Http\Actions;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Revolution\Line\Contracts\WebhookHandler;

class WebhookNullHandler implements WebhookHandler
{
    public function __invoke(Request $request): Response
    {
        // null

        return response(class_basename(static::class));
    }
}
