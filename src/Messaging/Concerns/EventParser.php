<?php

namespace Revolution\Line\Messaging\Concerns;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use LINE\Constants\HTTPHeader;
use LINE\Parser\EventRequestParser;
use LINE\Parser\Exception\InvalidEventRequestException;
use LINE\Parser\Exception\InvalidSignatureException;

trait EventParser
{
    /**
     * @throws InvalidEventRequestException
     * @throws InvalidSignatureException
     */
    public function parseEvent(Request $request): Collection
    {
        $signature = $request->header(HTTPHeader::LINE_SIGNATURE);

        $events = EventRequestParser::parseEventRequest(
            body: $request->getContent(),
            channelSecret: config('line.bot.channel_secret'),
            signature: $signature
        )->getEvents();

        return collect($events);
    }
}
