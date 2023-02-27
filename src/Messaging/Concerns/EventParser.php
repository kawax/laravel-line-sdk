<?php

namespace Revolution\Line\Messaging\Concerns;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use LINE\LINEBot\Constant\HTTPHeader;
use LINE\LINEBot\Exception\InvalidEventRequestException;
use LINE\LINEBot\Exception\InvalidSignatureException;

trait EventParser
{
    /**
     * @throws InvalidEventRequestException
     * @throws InvalidSignatureException
     */
    public function parseEvent(Request $request): Collection
    {
        $signature = $request->header(HTTPHeader::LINE_SIGNATURE);

        $events = $this->bot()->parseEventRequest($request->getContent(), $signature);

        return collect($events);
    }
}
