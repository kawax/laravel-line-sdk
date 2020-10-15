<?php

namespace Tests\Notifications;

use GuzzleHttp\Client;
use Tests\TestCase;
use Illuminate\Notifications\AnonymousNotifiable;
use Mockery;

class LineNotifyChannelTest extends TestCase
{
    protected function tearDown(): void
    {
        parent::tearDown();

        Mockery::close();
    }

    public function testLineNotifyChannel()
    {
        $client = Mockery::mock(Client::class);
        $client->shouldReceive('post')->once();

        $this->app->instance(Client::class, $client);

        (new AnonymousNotifiable())
            ->route('line-notify', 'test')
            ->notify(new LineNotifyStub('test'));
    }
}
