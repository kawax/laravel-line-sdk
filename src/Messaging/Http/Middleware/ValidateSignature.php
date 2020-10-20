<?php

namespace Revolution\Line\Messaging\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use LINE\LINEBot\Constant\HTTPHeader;

class ValidateSignature
{
    /**
     * @var string
     */
    protected $signature;

    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $this->signature = $request->header(HTTPHeader::LINE_SIGNATURE);

        if (empty($this->signature)) {
            abort(400);
        }

        if (! $this->validate($request)) {
            abort(400);
        }

        return $next($request); // @codeCoverageIgnore
    }

    /**
     * @param  Request  $request
     * @return bool
     */
    public function validate($request)
    {
        return hash_equals(base64_encode(hash_hmac(
            'sha256',
            $request->getContent(),
            config('line.bot.channel_secret'),
            true
        )), $this->signature);
    }
}
