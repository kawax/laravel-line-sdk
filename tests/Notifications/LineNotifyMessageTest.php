<?php

namespace Tests\Notifications;

use Revolution\Line\Notifications\LineNotifyMessage;
use Tests\TestCase;

class LineNotifyMessageTest extends TestCase
{
    public function testLineNotifyMessage()
    {
        $message = LineNotifyMessage::create('message')
            ->message('message')
            ->withSticker(1, 2)
            ->with([
                'imageThumbnail' => 'https://',
            ]);

        $this->assertEquals([
            'message' => 'message',
            'stickerPackageId' => 1,
            'stickerId' => 2,
            'imageThumbnail' => 'https://',
        ], $message->toArray());
    }
}
