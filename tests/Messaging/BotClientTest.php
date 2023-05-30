<?php

namespace Tests\Messaging;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use LINE\Clients\MessagingApi\Api\MessagingApiApi;
use Revolution\Line\Contracts\BotFactory;
use Revolution\Line\Facades\Bot;
use Revolution\Line\Messaging\Bot as BotAlias;
use Revolution\Line\Messaging\BotClient;
use Tests\TestCase;

class BotClientTest extends TestCase
{
    public function testBotInstance()
    {
        $this->assertInstanceOf(MessagingApiApi::class, app(MessagingApiApi::class));
        $this->assertInstanceOf(BotClient::class, app(BotFactory::class));
    }

    public function testBotUsing()
    {
        $bot = app(MessagingApiApi::class);
        $client = new BotClient($bot);

        $client->botUsing($bot);
        $this->assertInstanceOf(MessagingApiApi::class, $client->bot());

        $client->botUsing(function () use ($bot) {
            return $bot;
        });
        $this->assertInstanceOf(MessagingApiApi::class, $client->bot());
    }

    public function testMacroable()
    {
        Bot::macro('testMacro', function () {
            return 'test';
        });

        $this->assertSame('test', Bot::testMacro());
    }

    public function testBotInfo()
    {
        $this->mock(MessagingApiApi::class, function ($mock) {
            $mock->shouldReceive('getBotInfo')
                ->once()
                ->andReturn([]);
        });

        $this->assertSame([], Bot::getBotInfo());
    }

    public function testBotAlias()
    {
        $this->assertInstanceOf(MessagingApiApi::class, BotAlias::bot());
    }

    /**
     * @requires function \Illuminate\Http\Client\PendingRequest::get
     */
    public function testHttpMacro()
    {
        $this->assertInstanceOf(PendingRequest::class, Http::line());
    }
}
