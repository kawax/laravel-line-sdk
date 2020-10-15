<?php

namespace Tests\Notifications;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Mockery;
use Revolution\Line\Facades\LineNotify;
use Tests\TestCase;

class LineNotifyClientTest extends TestCase
{
    protected function tearDown(): void
    {
        parent::tearDown();

        Mockery::close();
    }

    public function testLineNotifyClient()
    {
        $response = Mockery::mock(Response::class);
        $response->shouldReceive('getBody')
            ->twice()
            ->andReturn('[]');

        $client = Mockery::mock(Client::class);
        $client->shouldReceive('sendRequest')
            ->twice()
            ->andReturn($response);

        $this->app->instance(Client::class, $client);

        $this->assertSame([], LineNotify::status('test'));
        $this->assertSame([], LineNotify::revoke('test'));
    }
}