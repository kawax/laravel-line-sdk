<?php

namespace Revolution\Line\Contracts;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

interface WebhookHandler
{
    public function __invoke(Request $request): mixed;
}
