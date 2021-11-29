<?php

namespace Revolution\Line\Contracts;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

interface WebhookHandler
{
    /**
     * @param  Request  $request
     * @return Response
     */
    public function __invoke(Request $request);
}
