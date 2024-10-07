<?php

namespace Tests\Notifications;

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
}
