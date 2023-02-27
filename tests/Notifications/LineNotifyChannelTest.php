<?php

namespace Tests\Notifications;

use Illuminate\Notifications\AnonymousNotifiable;
use Mockery;
use Revolution\Line\Notifications\LineNotifyChannel;
use Revolution\Line\Notifications\LineNotifyClient;
use Revolution\Line\Notifications\LineNotifyMessage;
use Tests\Notifications\Fixtures\LineNotifyStub;
use Tests\Notifications\Fixtures\TestNotifiableStub;
use Tests\TestCase;

class LineNotifyChannelTest extends TestCase
{
    public function testLineNotifyChannel()
    {
        $client = Mockery::mock(LineNotifyClient::class);
        $client->shouldReceive('withToken->notify')->with(
            [
                'message' => 'test',
                'stickerPackageId' => null,
                'stickerId' => null,
            ])->once();

        $channel = new LineNotifyChannel($client);

        $notifiable = (new AnonymousNotifiable())
            ->route('line-notify', 'test');

        $channel->send($notifiable, new LineNotifyStub('test'));
        $channel->send(new TestNotifiableStub(), new LineNotifyStub('test'));
    }

    public function testLineNotifyChannelNotArrayable()
    {
        $client = Mockery::mock(LineNotifyClient::class);
        $client->shouldReceive('withToken->notify')->never();

        $channel = new LineNotifyChannel($client);

        $notification = Mockery::mock(LineNotifyStub::class);
        $notification->shouldReceive('toLineNotify')
            ->andReturn(LineNotifyMessage::create(''));

        $channel->send(new TestNotifiableStub(), $notification);
    }
}
