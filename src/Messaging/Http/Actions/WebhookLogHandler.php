<?php

namespace Revolution\Line\Messaging\Http\Actions;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use LINE\LINEBot\Event\MessageEvent\TextMessage;
use Revolution\Line\Contracts\WebhookHandler;
use Revolution\Line\Facades\Bot;

class WebhookLogHandler implements WebhookHandler
{
    /**
     * @param  Request  $request
     * @return Response
     */
    public function __invoke(Request $request)
    {
        Bot::parseEvent($request)->each(function ($event) {
            /**
             * @var TextMessage $event
             */
            $context = [
                'type' => $event->getType(),
                'mode' => $event->getMode(),
                'timestamp' => $event->getTimestamp(),
                'replyToken' => $event->getReplyToken(),
            ];

            if (method_exists($event, 'getMessageType')) {
                $context['message.type'] = $event->getMessageType();
            }

            if (method_exists($event, 'getText')) {
                $context['message.text'] = $event->getText();
            }

            info(class_basename(get_class($event)), $context);
        });

        return response(class_basename(static::class));
    }
}
