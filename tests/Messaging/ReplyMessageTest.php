<?php

namespace Tests\Messaging;

use LINE\LINEBot;
use LINE\LINEBot\MessageBuilder\TextMessageBuilder;
use LINE\LINEBot\QuickReplyBuilder\QuickReplyMessageBuilder;
use Mockery as m;
use Revolution\Line\Facades\Bot;
use Revolution\Line\Messaging\ReplyMessage;
use Tests\TestCase;

class ReplyMessageTest extends TestCase
{
    public function testReplyMessageInstance()
    {
        $this->assertInstanceOf(ReplyMessage::class, Bot::reply('token'));
    }

    public function testReplyMessage()
    {
        $this->mock(LINEBot::class, function ($mock) {
            $mock->shouldReceive('replyMessage')
                ->once();
        });

        Bot::reply('token')
            ->message(new TextMessageBuilder('test'));
    }

    public function testReplyText()
    {
        $this->mock(LINEBot::class, function ($mock) {
            $mock->shouldReceive('replyMessage')
                ->once();
        });

        Bot::reply('token')->text('test');
    }

    public function testReplyTextWith()
    {
        $this->mock(LINEBot::class, function ($mock) {
            $mock->shouldReceive('replyMessage')
                ->once();
        });

        Bot::reply('token')
            ->withQuickReply(m::mock(QuickReplyMessageBuilder::class))
            ->withSender('name', 'icon')
            ->text('a', 'b', 'c');
    }

    public function testReplySticker()
    {
        $this->mock(LINEBot::class, function ($mock) {
            $mock->shouldReceive('replyMessage')
                ->once();
        });

        Bot::reply('token')->sticker(1, 2);
    }
}
