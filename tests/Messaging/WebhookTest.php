<?php

namespace Tests\Messaging;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;
use LINE\LINEBot;
use LINE\LINEBot\Constant\HTTPHeader;
use LINE\LINEBot\Event\MessageEvent\TextMessage;
use Mockery as m;
use Revolution\Line\Contracts\WebhookHandler;
use Revolution\Line\Messaging\Http\Actions\WebhookEventDispatcher;
use Revolution\Line\Messaging\Http\Actions\WebhookLogHandler;
use Revolution\Line\Messaging\Http\Actions\WebhookNullHandler;
use Tests\TestCase;

class WebhookTest extends TestCase
{
    /**
     * @var TextMessage
     */
    protected $message;

    protected function setUp(): void
    {
        parent::setUp();

        $this->message = new TextMessage([
            'replyToken' => '0f3779fba3b349968c5d07db31eab56f',
            'type' => 'message',
            'mode' => 'active',
            'timestamp' => 1462629479859,
            'source' => [
                'type' => 'user',
                'userId' => 'U4af4980629...',
            ],
            'message' => [
                'id' => '1',
                'type' => 'text',
                'text' => 'test',
            ],
        ]);
    }

    public function testWebhookHandler()
    {
        $this->assertInstanceOf(WebhookEventDispatcher::class, app(WebhookHandler::class));
    }

    public function testWebhookEventDispatcher()
    {
        Event::fake();

        $bot = m::mock(LINEBot::class);
        $bot->shouldReceive('parseEventRequest')
            ->once()
            ->andReturn([$this->message]);

        $this->app->instance(LINEBot::class, $bot);

        $response = $this->withoutMiddleware()
            ->post(config('line.bot.path'));

        Event::assertDispatched(TextMessage::class, function (TextMessage $event) {
            return $event->getText() === $this->message->getText();
        });

        $response->assertSuccessful()
            ->assertSee(class_basename(WebhookEventDispatcher::class));
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

    public function testWebhookLogHandler()
    {
        $this->app->singleton(WebhookHandler::class, WebhookLogHandler::class);

        $bot = m::mock(LINEBot::class);
        $bot->shouldReceive('parseEventRequest')
            ->once()
            ->andReturn([$this->message]);

        $this->app->instance(LINEBot::class, $bot);

        $context = [
            'replyToken' => $this->message->getReplyToken(),
            'type' => $this->message->getType(),
            'mode' => $this->message->getMode(),
            'timestamp' => $this->message->getTimestamp(),
            'message.type' => $this->message->getMessageType(),
            'message.text' => $this->message->getText(),
        ];

        Log::shouldReceive('info')
            ->once()
            ->with(class_basename(TextMessage::class), $context);

        $response = $this->withoutMiddleware()
            ->post(config('line.bot.path'));

        $response->assertSuccessful()
            ->assertSee(class_basename(WebhookLogHandler::class));
    }

    public function testWebhookNullHandler()
    {
        $this->app->singleton(WebhookHandler::class, WebhookNullHandler::class);

        Event::fake();

        $response = $this->withoutMiddleware()
            ->post(config('line.bot.path'));

        Event::assertNotDispatched(TextMessage::class);

        $response->assertSuccessful()
            ->assertSee(class_basename(WebhookNullHandler::class));
    }
}
