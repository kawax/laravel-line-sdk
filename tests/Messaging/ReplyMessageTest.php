<?php

namespace Tests\Messaging;

use LINE\LINEBot;
use LINE\LINEBot\MessageBuilder\TextMessageBuilder;
use Mockery;
use Revolution\Line\Facades\Bot;
use Revolution\Line\Messaging\ReplyMessage;
use Tests\TestCase;

class ReplyMessageTest extends TestCase
{
    protected function tearDown(): void
    {
        parent::tearDown();

        Mockery::close();
    }

    public function testReplyMessageInstance()
    {
        $this->assertInstanceOf(ReplyMessage::class, Bot::reply('token'));
    }

    public function testReplyMessage()
    {
        $bot = Mockery::mock(LINEBot::class);
        $bot->shouldReceive('replyMessage')
            ->once();

        $this->app->instance(LINEBot::class, $bot);

        Bot::reply('token')
            ->message(new TextMessageBuilder('test'));
    }

    public function testReplyText()
    {
        $bot = Mockery::mock(LINEBot::class);
        $bot->shouldReceive('replyMessage')
            ->twice();

        $this->app->instance(LINEBot::class, $bot);

        Bot::reply('token')->text('test');
        Bot::reply('token')->text('a', 'b', 'c');
    }
}
