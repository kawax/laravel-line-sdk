<?php

namespace Revolution\Line\Messaging\Http\Actions;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Revolution\Line\Contracts\WebhookHandler;
use Revolution\Line\Facades\Bot;

class WebhookEventDispatcher implements WebhookHandler
{
    public function __invoke(Request $request): Response
    {
        Bot::parseEvent($request)->each(fn ($event) => event($event));

        return response(class_basename(static::class));
    }
}
