<?php

namespace Revolution\Line\Messaging\Http\Actions;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use LINE\LINEBot\Constant\HTTPHeader;
use Revolution\Line\Contracts\WebhookHandler;
use Revolution\Line\Facades\Bot;

class WebhookEventDispatcher implements WebhookHandler
{
    /**
     * @param  Request  $request
     * @return Response
     */
    public function __invoke(Request $request)
    {
        $status = rescue(function () use ($request) {
            $signature = $request->header(HTTPHeader::LINE_SIGNATURE);

            $events = Bot::parseEventRequest($request->getContent(), $signature);

            collect($events)->each(function ($event) {
                event($event);
            });

            return 200;
        }, 400);

        return response(class_basename(static::class), $status);
    }
}
