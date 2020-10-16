<?php

namespace Tests\Notifications;

use Illuminate\Notifications\AnonymousNotifiable;
use Revolution\Line\Facades\LineNotify;
use Tests\TestCase;

class LineNotifyChannelTest extends TestCase
{
    public function testLineNotifyChannel()
    {
        LineNotify::shouldReceive('notify')->with(
            'test',
            [
                'message' => 'test',
                'stickerPackageId' => null,
                'stickerId' => null,
            ])->once();

        (new AnonymousNotifiable())
            ->route('line-notify', 'test')
            ->notify(new LineNotifyStub('test'));
    }
}
