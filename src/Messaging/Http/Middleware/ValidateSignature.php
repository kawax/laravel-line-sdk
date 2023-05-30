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
        if (! $request->hasHeader(HTTPHeader::LINE_SIGNATURE)) {
            abort(400, 'Request does not contain signature');
        }

        if (! $this->validateSignature($request)) {
            abort(400, 'Invalid signature has given');
        }

        if ($request->missing('events')) {
            abort(400, 'Invalid event request');
        }

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
