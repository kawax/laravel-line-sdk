# LINE Notify

wip

```
LINE_NOTIFY_CLIENT_ID=
LINE_NOTIFY_CLIENT_SECRET=
LINE_NOTIFY_REDIRECT=
LINE_NOTIFY_PERSONAL_ACCESS_TOKEN=
```

## User access token

Get user access token by using [Socialite](./socialite.md).

### User model
```php
    public function routeNotificationForLineNotify($notification)
    {
        return $this->notify_token;
    }
```

## Personal access token
If you're only going to use a specific notifier for on-demand notifications

```php
use Illuminate\Support\Facades\Notification;
use App\Notifications\LineNotifyTest;

Notification::route('line-notify', config('line.notify.personal_access_token'))
            ->notify(new LineNotifyTest('test'));
```
