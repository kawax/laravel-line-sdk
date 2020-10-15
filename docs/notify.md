# LINE Notify

wip

https://notify-bot.line.me/

## .env
```
LINE_NOTIFY_CLIENT_ID=
LINE_NOTIFY_CLIENT_SECRET=
LINE_NOTIFY_REDIRECT=
LINE_NOTIFY_PERSONAL_ACCESS_TOKEN=
```

## Create Notification
```
php artisan make:notification LineNotifyTest
```

Add `LineNotifyChannel` and `toLineNotify()`

```php
<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Revolution\Line\Notifications\LineNotifyChannel;
use Revolution\Line\Notifications\LineNotifyMessage;

class LineNotifyTest extends Notification
{
    use Queueable;

    /**
     * @var string
     */
    protected $message;

    /**
     * Create a new notification instance.
     *
     * @param  string  $message
     *
     * @return void
     */
    public function __construct($message)
    {
        $this->message = $message;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [
            LineNotifyChannel::class
        ];
    }

    /**
     * @param  mixed  $notifiable
     * @return LineNotifyMessage
     */
    public function toLineNotify($notifiable)
    {
        return LineNotifyMessage::create($this->message);
    }
}
```

## LineNotifyMessage

```php
use Revolution\Line\Notifications\LineNotifyMessage;

return LineNotifyMessage::create('message')
            ->withSticker(1, 1)
            ->with([
                'imageThumbnail' => 'https://',
            ]);
```

```php
return (new LineNotifyMessage())->message('message')
            ->withSticker(1, 2)
            ->with([
                'imageFullsize' => 'https://',
            ]);
```

Only some stickers can be used.  
https://devdocs.line.me/files/sticker_list.pdf

## User access token

Get user access token by using [Socialite](./socialite.md).

### User model
```php
    /**
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return string
     */
    public function routeNotificationForLineNotify($notification)
    {
        return $this->notify_token;
    }
```

### Send notifications to user
```php
$user->notify(new LineNotifyTest('test'));
```

## Personal access token
If you're only going to use a specific notifier for on-demand notifications

```php
use Illuminate\Support\Facades\Notification;
use App\Notifications\LineNotifyTest;

Notification::route('line-notify', config('line.notify.personal_access_token'))
            ->notify(new LineNotifyTest('test'));
```

## LINE Notify API
```php
use Revolution\Line\Facades\LineNotify;

$res = LineNotify::status($token);
$res = LineNotify::revoke($token);
```
