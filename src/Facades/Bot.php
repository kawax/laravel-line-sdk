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
 * @method static Response replyMessage($replyToken, MessageBuilder $messageBuilder)
 * @method static Response replyText($replyToken, $text, $extraTexts = null)
 * @method static Response pushMessage($to, MessageBuilder $messageBuilder, $notificationDisabled = false, $retryKey = null)
 *
 * @see \LINE\LINEBot
 * @see \Revolution\Line\Messaging\BotClient
 */
class Bot extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return BotFactory::class;
    }
}
