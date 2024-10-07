# Laravel Notifications

Messaging API version.

## Notification class

```php
use Illuminate\Notifications\Notification;
use Revolution\Line\Notifications\LineChannel;
use Revolution\Line\Notifications\LineMessage;

class TestNotification extends Notification
{
    public function via(object $notifiable): array
    {
        return [
            LineChannel::class
        ];
    }

    public function toLine(object $notifiable): LineMessage
    {
        return LineMessage::create(text: 'test');
    }
}
```

## On-Demand Notifications

```php
use Illuminate\Support\Facades\Notification;

Notification::route('line', 'to')
            ->notify(new TestNotification());
```

## User Notifications

```php
use Illuminate\Notifications\Notifiable;

class User
{
    use Notifiable;

    public function routeNotificationForLine($notification): string
    {
        return $this->line_id;
    }
}
```

```php
$user->notify(new TestNotification());
```

## to

userId or groupId.

## TextMessage

```php
use Revolution\Line\Notifications\LineMessage;

    public function toLine(object $notifiable): LineMessage
    {
        return LineMessage::create()
                          ->text('test');
    }
```

## StickerMessage

Only the stickers on this page can be used.
https://developers.line.biz/en/docs/messaging-api/sticker-list/

```php
use Revolution\Line\Notifications\LineMessage;

    public function toLine(object $notifiable): LineMessage
    {
        return LineMessage::create()
                          ->text('test')
                          ->sticker(package: 446, sticker: 1988);
    }
```

## ImageMessage

Specify a public URL.

```php
use Revolution\Line\Notifications\LineMessage;

    public function toLine(object $notifiable): LineMessage
    {
        return LineMessage::create()
                          ->image(original: 'https://.../test.png', preview: 'https://.../preview.png');
    }
```
