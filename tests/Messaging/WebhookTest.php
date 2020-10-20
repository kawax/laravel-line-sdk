<?php

namespace Tests\Messaging;

use Illuminate\Support\Facades\Event;
use LINE\LINEBot\Constant\HTTPHeader;
use LINE\LINEBot\Event\MessageEvent\TextMessage;
use Revolution\Line\Contracts\WebhookHandler;
use Revolution\Line\Facades\Bot;
use Revolution\Line\Messaging\Http\Actions\WebhookEventDispatcher;
use Tests\TestCase;

class WebhookTest extends TestCase
{
    public function testWebhookHandler()
    {
        $this->assertInstanceOf(WebhookEventDispatcher::class, app(WebhookHandler::class));
    }

    public function testWebhookEventDispatched()
    {
        Event::fake();

        Bot::shouldReceive('parseEventRequest')->once()->andReturn([
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

        $response = $this->withoutMiddleware()
            ->post(config('line.bot.path'));

        Event::assertDispatched(TextMessage::class);

        $response->assertSuccessful();
    }

    public function testInvalidSignature()
    {
        Event::fake();

        $response = $this->post(config('line.bot.path'));

        Event::assertNotDispatched(TextMessage::class);

        $response->assertStatus(400);
    }

    public function testInvalidEventRequest()
    {
        Event::fake();

        $response = $this->withHeader(HTTPHeader::LINE_SIGNATURE, 'test')->post(config('line.bot.path'));

        Event::assertNotDispatched(TextMessage::class);

        $response->assertStatus(400);
    }
}
