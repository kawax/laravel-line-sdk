<?php

namespace Revolution\Line\Messaging\Http\Actions;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use LINE\Webhook\Model\MessageEvent;
use Revolution\Line\Contracts\WebhookHandler;
use Revolution\Line\Facades\Bot;

class WebhookLogHandler implements WebhookHandler
{
    public function __invoke(Request $request): Response
    {
        Bot::parseEvent($request)->each(function ($event) {
            /**
             * @var MessageEvent $event
             */
            $context = [
                'type' => $event->getType(),
                'mode' => $event->getMode(),
                'timestamp' => $event->getTimestamp(),
                'replyToken' => $event->getReplyToken(),
            ];

            info(class_basename(get_class($event)), $context);
        });

        return response(class_basename(static::class));
    }
}
