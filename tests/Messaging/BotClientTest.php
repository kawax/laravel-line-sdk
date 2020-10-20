<?php

namespace Tests\Messaging;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use LINE\LINEBot;
use Mockery;
use Revolution\Line\Contracts\BotFactory;
use Revolution\Line\Facades\Bot;
use Revolution\Line\Messaging\Bot as BotAlias;
use Revolution\Line\Messaging\BotClient;
use Tests\TestCase;

class BotClientTest extends TestCase
{
    protected function tearDown(): void
    {
        parent::tearDown();

        Mockery::close();
    }

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

    public function testBotInfo()
    {
        $bot = Mockery::mock(LINEBot::class);
        $bot->shouldReceive('getBotInfo')
            ->once()
            ->andReturn([]);

        $this->app->instance(LINEBot::class, $bot);

        $this->assertSame([], Bot::getBotInfo());
    }

    public function testBotAlias()
    {
        $this->assertInstanceOf(LINEBot::class, BotAlias::bot());
    }

    /**
     * @requires function \Illuminate\Http\Client\PendingRequest::get
     */
    public function testHttpMacro()
    {
        $this->assertInstanceOf(PendingRequest::class, Http::line());
    }
}
