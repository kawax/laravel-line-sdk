<?php

namespace Revolution\Line\Messaging\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Revolution\Line\Contracts\WebhookHandler;
use Revolution\Line\Messaging\Http\Middleware\ValidateSignature;

class WebhookController extends Controller
{
    /**
     * WebhookController constructor.
     */
    public function __construct()
    {
        $this->middleware(ValidateSignature::class);
    }

    /**
     * @param  Request  $request
     * @return Response
     */
    public function __invoke(Request $request)
    {
        return app(WebhookHandler::class)($request);
    }
}
