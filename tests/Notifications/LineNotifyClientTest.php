<?php

namespace Tests\Notifications;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Utils;
use Illuminate\Support\Facades\Http;
use Mockery as m;
use Revolution\Line\Facades\LineNotify;
use Tests\TestCase;

class LineNotifyClientTest extends TestCase
{
    public function testLineNotifyClient()
    {
        Http::fake(fn () => Http::response([]));

        $this->assertSame([], LineNotify::withToken('test')->notify([]));
        $this->assertSame([], LineNotify::withToken('test')->status());
        $this->assertSame([], LineNotify::withToken('test')->revoke());

        Http::assertSentCount(3);
    }
}
