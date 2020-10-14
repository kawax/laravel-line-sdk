<?php

namespace Tests\Messaging;

use LINE\LINEBot;
use Revolution\Line\Contracts\BotFactory;
use Revolution\Line\Facades\Bot;
use Revolution\Line\Messaging\BotClient;
use Tests\TestCase;

class BotClientTest extends TestCase
{
    public function testBotInstance()
    {
        $this->assertInstanceOf(LINEBot::class, app(LINEBot::class));
        $this->assertInstanceOf(BotClient::class, app(BotFactory::class));
    }

    public function testBotUsing()
    {
        $bot = app(LINEBot::class);
        $client = new BotClient($bot);

        $client->botUsing($bot);
        $this->assertInstanceOf(LINEBot::class, $client->bot());

        $client->botUsing(function () use ($bot) {
            return $bot;
        });
        $this->assertInstanceOf(LINEBot::class, $client->bot());
    }

    public function testMacroable()
    {
        Bot::macro('testMacro', function () {
            return 'test';
        });

        $this->assertSame('test', Bot::testMacro());
    }
}
