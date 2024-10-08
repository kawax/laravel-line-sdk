<?php

namespace Tests\Notifications;

use Revolution\Line\Notifications\LineNotifyMessage;
use Tests\TestCase;

/**
 * @deprecated
 */
class LineNotifyMessageTest extends TestCase
{
    public function testLineNotifyMessage()
    {
        $message = LineNotifyMessage::create('message')
            ->message('message')
            ->withSticker(package: 1, id: 2)
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
