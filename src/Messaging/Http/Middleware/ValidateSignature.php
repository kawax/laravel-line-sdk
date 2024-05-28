<?php

namespace Revolution\Line\Messaging\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use LINE\Constants\HTTPHeader;
use LINE\Parser\Exception\InvalidSignatureException;
use LINE\Parser\SignatureValidator;

class ValidateSignature
{
    /**
     * Handle an incoming request.
     *
     * @throws InvalidSignatureException
     */
    public function handle(Request $request, Closure $next): mixed
    {
        abort_unless($request->hasHeader(HTTPHeader::LINE_SIGNATURE), 400, 'Request does not contain signature');

        abort_unless($this->validateSignature($request), 400, 'Invalid signature has given');

        abort_if($request->missing('events'), 400, 'Invalid event request');

        return $next($request); // @codeCoverageIgnore
    }

    /**
     * @throws InvalidSignatureException
     */
    protected function validateSignature(Request $request): bool
    {
        return SignatureValidator::validateSignature(
            $request->getContent(),
            config('line.bot.channel_secret'),
            $request->header(HTTPHeader::LINE_SIGNATURE)
        );
    }
}
