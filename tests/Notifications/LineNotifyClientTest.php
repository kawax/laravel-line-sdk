<?php

namespace Tests\Notifications;

use Illuminate\Support\Facades\Http;
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
