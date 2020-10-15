<?php

namespace Tests\Messaging;

use LINE\LINEBot;
use LINE\LINEBot\MessageBuilder\TextMessageBuilder;
use LINE\LINEBot\QuickReplyBuilder\QuickReplyMessageBuilder;
use LINE\LINEBot\SenderBuilder\SenderMessageBuilder;
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
            ->once();

        $this->app->instance(LINEBot::class, $bot);

        Bot::reply('token')->text('test');
    }

    public function testReplyTextWith()
    {
        $bot = Mockery::mock(LINEBot::class);
        $bot->shouldReceive('replyMessage')
            ->once();

        $this->app->instance(LINEBot::class, $bot);

        Bot::reply('token')
            ->withQuickReply(Mockery::mock(QuickReplyMessageBuilder::class))
            ->withSender('name', 'icon')
            ->text('a', 'b', 'c');
    }

    public function testReplySticker()
    {
        $bot = Mockery::mock(LINEBot::class);
        $bot->shouldReceive('replyMessage')
            ->once();

        $this->app->instance(LINEBot::class, $bot);

        Bot::reply('token')->sticker(1, 2);
    }
}
