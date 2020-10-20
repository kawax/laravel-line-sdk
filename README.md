# LINE SDK for Laravel

[![Build Status](https://travis-ci.com/kawax/laravel-line-sdk.svg?branch=master)](https://travis-ci.com/kawax/laravel-line-sdk)
![tests](https://github.com/kawax/laravel-line-sdk/workflows/tests/badge.svg)
[![Maintainability](https://api.codeclimate.com/v1/badges/99eef5006575c054a859/maintainability)](https://codeclimate.com/github/kawax/laravel-line-sdk/maintainability)
[![Test Coverage](https://api.codeclimate.com/v1/badges/99eef5006575c054a859/test_coverage)](https://codeclimate.com/github/kawax/laravel-line-sdk/test_coverage)
[![Codacy Badge](https://api.codacy.com/project/badge/Grade/cdeca7c2d37b4def9cce5f73b66e04da)](https://app.codacy.com/gh/kawax/laravel-line-sdk?utm_source=github.com&utm_medium=referral&utm_content=kawax/laravel-line-sdk&utm_campaign=Badge_Grade)

## Features
- Working with Laravel Event System. Including Webhook routing and controller.
- Extensible Bot Client.
- Working with Laravel Notification System(LINE Notify)
- Including Socialite drivers(LINE Login, LINE Notify)

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

LINE_NOTIFY_CLIENT_ID=
LINE_NOTIFY_CLIENT_SECRET=
LINE_NOTIFY_REDIRECT=
LINE_NOTIFY_PERSONAL_ACCESS_TOKEN=
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

## Documents
- [Messaging API / Bot](./docs/bot.md)
- [Socialite](./docs/socialite.md)
- [Notifications](./docs/notify.md)

## Demo
https://github.com/kawax/laravel-line-project

## LICENSE
MIT
