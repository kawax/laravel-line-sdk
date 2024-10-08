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

userId or groupId. ID can be obtained from FollowEvent or JoinEvent.

## TextMessage

You can send up to 5 messages.

```php
use Revolution\Line\Notifications\LineMessage;

    public function toLine(object $notifiable): LineMessage
    {
        return LineMessage::create()
                          ->text('text 1')
                          ->text('text 2');
    }
```

## Customize icon and display name

Make sure you use `withSender()` before any other message adding methods.

```php
use Revolution\Line\Notifications\LineMessage;

    public function toLine(object $notifiable): LineMessage
    {
        return LineMessage::create()
                          ->withSender(name: 'alt-name', icon: 'https://...png')
                          ->text('text 1')
                          ->text('text 2');
    }
```

You can also specify a name and icon with `create()` method, which is easier if you're just creating a single text message.

```php
use Revolution\Line\Notifications\LineMessage;

    public function toLine(object $notifiable): LineMessage
    {
        return LineMessage::create(text: 'test', name: 'alt-name', icon: 'https://...png');
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

## VideoMessage

Specify a public URL.

```php
use Revolution\Line\Notifications\LineMessage;

    public function toLine(object $notifiable): LineMessage
    {
        return LineMessage::create()
                          ->video(original: 'https://.../test.mp4', preview: 'https://.../preview.png');
    }
```

## Other Message Types

You can add any message type with `message()`. Don't forget to specify the type with `setType()`.

```php
use LINE\Clients\MessagingApi\Model\LocationMessage;
use LINE\Constants\MessageType;
use Revolution\Line\Notifications\LineMessage;

    public function toLine(object $notifiable): LineMessage
    {
        $location = (new LocationMessage())
            ->setType(MessageType::LOCATION)
            ->setTitle('title')
            ->setAddress('address')
            ->setLatitude(0.0)
            ->setLongitude(0.0);
            
        return LineMessage::create()
                          ->message($location);
    }
```
