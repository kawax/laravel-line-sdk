<?php

namespace Revolution\Line\Contracts;

use Illuminate\Http\Request;

interface WebhookHandler
{
    public function __invoke(Request $request): mixed;
}
