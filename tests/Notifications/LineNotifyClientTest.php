<?php

namespace Tests\Notifications;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Mockery as m;
use Revolution\Line\Facades\LineNotify;
use Tests\TestCase;

class LineNotifyClientTest extends TestCase
{
    public function testLineNotifyClient()
    {
        $response = m::mock(Response::class);
        $response->shouldReceive('getBody')
            ->times(3)
            ->andReturn('[]');

        $client = m::mock(Client::class);
        $client->shouldReceive('send')
            ->times(3)
            ->andReturn($response);

        $this->instance(Client::class, $client);

        $this->assertSame([], LineNotify::withToken('test')->notify([]));
        $this->assertSame([], LineNotify::withToken('test')->status());
        $this->assertSame([], LineNotify::withToken('test')->revoke());
    }
}
