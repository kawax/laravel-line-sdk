<?php

namespace Tests\Notifications;

use LINE\Clients\MessagingApi\Model\LocationMessage;
use LINE\Clients\MessagingApi\Model\QuickReply;
use LINE\Constants\MessageType;
use Revolution\Line\Notifications\LineMessage;
use Tests\TestCase;

class LineMessageTest extends TestCase
{
    public function testLineMessage()
    {
        $message = LineMessage::create('test1')
            ->text('test2')
            ->sticker(package: 1, sticker: 2)
            ->image(original: '', preview: '')
            ->video(original: '', preview: '')
            ->with([
                'notificationDisabled' => false,
            ]);

        $this->assertArrayHasKey('messages', $message->toArray());
        $this->assertArrayHasKey('notificationDisabled', $message->toArray());
    }

    public function test_location_message()
    {
        $location = (new LocationMessage())
            ->setType(MessageType::LOCATION)
            ->setTitle('title')
            ->setAddress('address')
            ->setLatitude(0.0)
            ->setLongitude(0.0);

        $message = (new LineMessage())
            ->text('text')
            ->message($location);

        $this->assertArrayHasKey('messages', $message->toArray());
        $this->assertInstanceOf(LocationMessage::class, $message->toArray()['messages'][1]);
    }

    public function test_create_with_sender()
    {
        $message = LineMessage::create(text: 'test', name: 'name', icon: 'icon');

        $sender = $message->toArray()['messages'][0]->getSender();
        $this->assertSame('name', $sender->getName());
        $this->assertSame('icon', $sender->getIconUrl());
    }

    public function test_sender()
    {
        $message = (new LineMessage())
            ->withSender(name: 'name', icon: 'icon')
            ->text('test');

        $sender = $message->toArray()['messages'][0]->getSender();
        $this->assertSame('name', $sender->getName());
        $this->assertSame('icon', $sender->getIconUrl());
    }

    public function test_sender_wrong_order()
    {
        $message = (new LineMessage())
            ->text('test')
            ->withSender(name: 'name', icon: 'icon');

        $sender = $message->toArray()['messages'][0]->getSender();
        $this->assertNull($sender);
    }

    public function test_sender_name()
    {
        $message = (new LineMessage())
            ->withSender(name: 'name')
            ->text('test');

        $this->assertSame('name', $message->toArray()['messages'][0]->getSender()->getName());
    }

    public function test_sender_icon()
    {
        $message = (new LineMessage())
            ->withSender(icon: 'icon')
            ->text('test');

        $this->assertSame('icon', $message->toArray()['messages'][0]->getSender()->getIconUrl());
    }

    public function test_quick_reply()
    {
        $message = (new LineMessage())
            ->withQuickReply($quick = new QuickReply(['items' => []]))
            ->text('test');

        $this->assertSame($quick, $message->toArray()['messages'][0]->getQuickReply());
    }
}
