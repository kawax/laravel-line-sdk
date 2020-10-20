<?php

namespace Revolution\Line\Messaging\Concerns;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use LINE\LINEBot\Constant\HTTPHeader;

trait EventParser
{
    /**
     * @param  Request  $request
     * @return Collection
     */
    public function parseEvent(Request $request)
    {
        $signature = $request->header(HTTPHeader::LINE_SIGNATURE);

        $events = $this->bot()->parseEventRequest($request->getContent(), $signature);

        return collect($events);
    }
}
