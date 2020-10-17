# Messaging API / Bot

https://developers.line.biz/en/docs/messaging-api/

## Bot
`Revolution\Line\Facades\Bot` can use all methods of the `LINEBot` class.

Delegate to LINEBot.
```php
use Revolution\Line\Facades\Bot;

Bot::replyText();
Bot::replyMessage();
Bot::pushMessage();
```

It also has the original `reply` function.

```php
use Revolution\Line\Facades\Bot;

Bot::reply($token)->text('text');
Bot::reply($token)->withSender('alt-name')->text('text1', 'text2');
Bot::reply($token)->sticker(1, 1);
```

## Webhook

The SDK includes Webhook routing and controller.

### Webhook URL
`https://localhost/line/webhook`

You can change `line/webhook` in .env

```
LINE_BOT_WEBHOOK_PATH=webhook
```

### Working with Laravel Event System
When a Webhook event is received, Laravel event is dispatching.

For Event discovery, add `shouldDiscoverEvents()` to your `EventServiceProvider`
```php
/**
 * Determine if events and listeners should be automatically discovered.
 *
 * @return bool
 */
public function shouldDiscoverEvents()
{
    return true;
}
```
No need to change $listen.

Note: In production, you should run `php artisan event:cache` command.

### Publishing default Listeners
Publish to `app/Listeners`.

All listeners.
```
php artisan vendor:publish --tag=line-listeners-all
```
Message event listeners only.
```
php artisan vendor:publish --tag=line-listeners-message
```

For example, `LINE\LINEBot\Event\MessageEvent\TextMessage` event is handled by `TextMessageListener`.

### Listener@handle() must have type hint
You can also make a new listener.

```
php artisan make:listener TextListener
```

Be sure to add a type hint that matches the event type.

```php
<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use LINE\LINEBot\Event\MessageEvent\TextMessage;
use Revolution\Line\Facades\Bot;

class TextListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  TextMessage  $event
     * @return void
     */
    public function handle(TextMessage $event)
    {
        Bot::reply($event->getReplyToken())->text($event->getText());
    }
}
```

### Easy to use Queue

```php
use Illuminate\Contracts\Queue\ShouldQueue;

class TextMessageListener implements ShouldQueue
{
    //
}
```

## Customizing

### Bot macro
`Bot` is Macroable, it means "You can add any method"

Register at `AppServiceProvider@boot`
```php
use Revolution\Line\Facades\Bot;

    public function boot()
    {
        Bot::macro('foo', function () {
            return $this->bot()->...
        });
    }
```
Use it anywhere.
```php
$foo = Bot::foo();
```

### Replacing `LINEBot` instance
`Bot::bot()` returns LINEBot instance. You can swap instances with `Bot::botUsing()`

```php
$bot = new MyBot();

Bot::botUsing($bot);
```
Accepts a callable.
```php
Bot::botUsing(function () {
   return new MyBot();
});
```

### Webhook default route middleware
The `throttle` middleware is enabled. To disable it, configure in `.env`.

```
LINE_BOT_WEBHOOK_MIDDLEWARE=null
```

Or change the `throttle` settings.

```
LINE_BOT_WEBHOOK_MIDDLEWARE=throttle:120,1
```

Laravel>=8
```php
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;

RateLimiter::for('line', function (Request $request) {
    return Limit::perMinute(120);
});
```
```
LINE_BOT_WEBHOOK_MIDDLEWARE=throttle:line
```

### Another way not to use the Laravel Event system

Make your `app/Actions/LineWebhook.php`

```php
<?php
namespace App\Actions;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Revolution\Line\Contracts\WebhookHandler;
use Revolution\Line\Facades\Bot;
use LINE\LINEBot\Constant\HTTPHeader;
use LINE\LINEBot\Event\MessageEvent\TextMessage;
use LINE\LINEBot\Exception\InvalidEventRequestException;
use LINE\LINEBot\Exception\InvalidSignatureException;

class LineWebhook implements WebhookHandler
{
    /**
     * @param  Request  $request
     * @return Response
     */
    public function __invoke(Request $request)
    {
        try {
            $signature = $request->header(HTTPHeader::LINE_SIGNATURE);

            $events = Bot::parseEventRequest($request->getContent(), $signature);

            collect($events)->each(function ($event) {
                //event($event);
                if($event instanceof TextMessage){
                    //
                }
            });
        } catch (InvalidSignatureException $e) {
            report($e);
            abort(400, $e->getMessage());
        } catch (InvalidEventRequestException $e) {
            report($e);
            abort(400, 'Invalid event request');
        }

        return response('OK');
    }
}
```

Register at `AppServiceProvider@register`
```php
use App\Actions\LineWebhook;
use Revolution\Line\Contracts\WebhookHandler;

public function register()
{
    $this->app->singleton(WebhookHandler::class, LineWebhook::class);
}
```

Anything is possible by replacing the WebhookHandler.

### Http::line() (Required Laravel>=7)
We've already extended the `Http` class, so you can make API requests without using the LINEBot class.

```php
use Illuminate\Support\Facades\Http;

$response = Http::line()->post('/v2/bot/channel/webhook/test', [
                            'endpoint' => '',
                        ]);
```

Combine with Bot macro.

```php
use Illuminate\Support\Facades\Http;
use Revolution\Line\Facades\Bot;

Bot::macro('verifyWebhook', function ($endpoint = '') {
    return Http::line()->post('/v2/bot/channel/webhook/test', [
        'endpoint' => $endpoint,
    ])->json();
});
```

```php
$response = Bot::verifyWebhook();
```
