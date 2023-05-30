<?php

namespace Revolution\Line\Facades;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Facade;
use LINE\Clients\MessagingApi\Api\MessagingApiApi;
use Revolution\Line\Contracts\BotFactory;
use Revolution\Line\Messaging\ReplyMessage;

/**
 * @method static ReplyMessage reply(string $token)
 * @method static Collection parseEvent(Request $request)
 * @method static void replyMessage(\LINE\Clients\MessagingApi\Model\ReplyMessageRequest $replyMessageRequest, string $contentType = MessagingApiApi::contentTypes['replyMessage'][0])
 * @method static void pushMessage(\LINE\Clients\MessagingApi\Model\PushMessageRequest $pushMessageRequest, string $xLineRetryKey = null, string $contentType = MessagingApiApi::contentTypes['pushMessage'][0])
 *
 * @see \LINE\Clients\MessagingApi\Api\MessagingApiApi
 * @see \Revolution\Line\Messaging\BotClient
 */
class Bot extends Facade
{
    /**
     * Get the registered name of the component.
     */
    protected static function getFacadeAccessor(): string
    {
        return BotFactory::class;
    }
}
