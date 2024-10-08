<?php

namespace Tests\Notifications;

use LINE\Clients\MessagingApi\Model\LocationMessage;
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
}
