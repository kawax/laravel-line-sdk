<?php

namespace Tests\Messaging;

use Illuminate\Support\Facades\Event;
use LINE\LINEBot;
use LINE\LINEBot\Constant\HTTPHeader;
use LINE\LINEBot\Event\MessageEvent\TextMessage;
use Mockery;
use Revolution\Line\Contracts\WebhookHandler;
use Revolution\Line\Messaging\Http\Actions\WebhookEventDispatcher;
use Tests\TestCase;

class WebhookTest extends TestCase
{
    protected function tearDown(): void
    {
        parent::tearDown();

        Mockery::close();
    }

    public function testWebhookHandler()
    {
        $this->assertInstanceOf(WebhookEventDispatcher::class, app(WebhookHandler::class));
    }

    public function testWebhookEventDispatched()
    {
        Event::fake();

        $bot = Mockery::mock(LINEBot::class);
        $bot->shouldReceive('parseEventRequest')
            ->once()
            ->andReturn([
                new TextMessage([
                    'replyToken' => '0f3779fba3b349968c5d07db31eab56f',
                    'type' => 'message',
                    'mode' => 'active',
                    'timestamp' => 1462629479859,
                    'source' => [
                        'type' => 'user',
                        'userId' => 'U4af4980629...',
                    ],
                    'message' => [
                        'id' => '',
                        'type' => '',
                        'text' => '',
                    ],
                ]),
            ]);

        $this->app->instance(LINEBot::class, $bot);

        $response = $this->withoutMiddleware()
            ->post(config('line.bot.path'));

        Event::assertDispatched(TextMessage::class);

        $response->assertSuccessful();
    }

    public function testEmptySignature()
    {
        Event::fake();

        $response = $this->postJson(config('line.bot.path'));

        Event::assertNotDispatched(TextMessage::class);

        $response->assertStatus(400)
            ->assertJson([
                'message' => 'Request does not contain signature',
            ]);
    }

    public function testInvalidSignature()
    {
        Event::fake();

        $response = $this->withHeader(HTTPHeader::LINE_SIGNATURE, 'test')->postJson(config('line.bot.path'));

        Event::assertNotDispatched(TextMessage::class);

        $response->assertStatus(400)
            ->assertJson([
                'message' => 'Invalid signature has given',
            ]);
    }

    public function testValidSignatureEmptyEvents()
    {
        $signature = base64_encode(hash_hmac('sha256', json_encode(['test']), config('line.bot.channel_secret'), true));

        Event::fake();

        $response = $this->withHeader(HTTPHeader::LINE_SIGNATURE, $signature)
            ->postJson(config('line.bot.path'), [
                'test',
            ]);

        Event::assertNotDispatched(TextMessage::class);

        $response->assertStatus(400)
            ->assertJson([
                'message' => 'Invalid event request',
            ]);
    }
}
