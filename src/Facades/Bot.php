<?php

namespace Revolution\Line\Facades;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Facade;
use LINE\LINEBot\MessageBuilder;
use LINE\LINEBot\Response;
use Revolution\Line\Contracts\BotFactory;
use Revolution\Line\Messaging\ReplyMessage;

/**
 * @method static ReplyMessage reply(string $token)
 * @method static Collection parseEvent(Request $request)
 * @method static Response replyMessage(string $replyToken, MessageBuilder $messageBuilder)
 * @method static Response replyText(string $replyToken, string $text, ?array $extraTexts = null)
 * @method static Response pushMessage(string $to, MessageBuilder $messageBuilder, bool $notificationDisabled = false, ?string $retryKey = null, array $customAggregationUnits = [])
 *
 * @see \LINE\LINEBot
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
