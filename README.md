# LINE SDK for Laravel

## Requirements
- PHP >= 7.2
- Laravel >= 6.0

## Versioning
- Basic : semver
- Drop old PHP or Laravel version : `+0.1`. composer should handle it well.
- Support only latest major version (`master` branch), but you can PR to old branches.

## Installation

```
composer require revolution/laravel-line-sdk
```

## Configuration

### .env
```
LINE_BOT_CHANNEL_TOKEN=
LINE_BOT_CHANNEL_SECRET=

LINE_LOGIN_CLIENT_ID=
LINE_LOGIN_CLIENT_SECRET=
LINE_LOGIN_REDIRECT=
```

### Publishing(Optional)

```
php artisan vendor:publish --tag=line-config
```

### Short Facade(Optional)
Recent Laravel uses a full namespace.

```php
use Revolution\Line\Facades\Bot;

Bot::replyText();
```

If you want to use the short Facade, you can add it manually in `config/app.php`.

```php
    'aliases' => [
        'LINE' => Revolution\Line\Facades\Bot::class,
    ],
```

```php
use LINE;

LINE::replyText();
```

## License
MIT
