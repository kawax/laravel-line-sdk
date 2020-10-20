<?php

namespace Revolution\Line\Facades;

use Illuminate\Support\Facades\Facade;
use Revolution\Line\Contracts\BotFactory;

/**
 * @method static \LINE\LINEBot\Response replyMessage($replyToken, \LINE\LINEBot\MessageBuilder $messageBuilder)
 * @method static \LINE\LINEBot\Response replyText($replyToken, $text, $extraTexts = null)
 * @method static \Revolution\Line\Messaging\ReplyMessage reply(string $token)
 * @method static \LINE\LINEBot\Response pushMessage($to, \LINE\LINEBot\MessageBuilder $messageBuilder, $notificationDisabled = false, $retryKey = null)
 * @method static mixed parseEventRequest($body, $signature, $eventOnly = true)
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
