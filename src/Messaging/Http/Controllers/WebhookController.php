<?php

namespace Revolution\Line\Messaging\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Revolution\Line\Contracts\WebhookHandler;

class WebhookController
{
    /**
     * @param  Request  $request
     * @return Response
     */
    public function __invoke(Request $request)
    {
        return app(WebhookHandler::class)($request);
    }
}
