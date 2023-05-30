<?php

namespace Tests\Messaging;

use LINE\Clients\MessagingApi\Api\MessagingApiApi;
use LINE\Clients\MessagingApi\Model\QuickReply;
use LINE\Clients\MessagingApi\Model\TextMessage;
use LINE\Constants\MessageType;
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
        $this->mock(MessagingApiApi::class, function ($mock) {
            $mock->shouldReceive('replyMessage')
                ->once();
        });

        Bot::reply('token')
            ->message(new TextMessage(['text' => 'test', 'type' => MessageType::TEXT]));
    }

    public function testReplyText()
    {
        $this->mock(MessagingApiApi::class, function ($mock) {
            $mock->shouldReceive('replyMessage')
                ->once();
        });

        Bot::reply('token')->text('test');
    }

    public function testReplyTextWith()
    {
        $this->mock(MessagingApiApi::class, function ($mock) {
            $mock->shouldReceive('replyMessage')
                ->once();
        });

        Bot::reply('token')
            ->withQuickReply(m::mock(QuickReply::class))
            ->withSender('name', 'icon')
            ->text('a', 'b', 'c');
    }

    public function testReplySticker()
    {
        $this->mock(MessagingApiApi::class, function ($mock) {
            $mock->shouldReceive('replyMessage')
                ->once();
        });

        Bot::reply('token')->sticker(1, 2);
    }
}
