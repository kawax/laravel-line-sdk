<?php

return [
    /**
     * Messaging / Bot.
     */
    'bot' => [
        'channel_token' => env('LINE_BOT_CHANNEL_TOKEN'),
        'channel_secret' => env('LINE_BOT_CHANNEL_SECRET'),
        'path' => env('LINE_BOT_WEBHOOK_PATH', 'line/webhook'),
        'route' => env('LINE_BOT_WEBHOOK_ROUTE', 'line.webhook'),
        'domain' => env('LINE_BOT_WEBHOOK_DOMAIN'),
        'middleware' => env('LINE_BOT_WEBHOOK_MIDDLEWARE', ['throttle']),
    ],

    /**
     * LINE Login.
     */
    'login' => [
        'client_id' => env('LINE_LOGIN_CLIENT_ID'),
        'client_secret' => env('LINE_LOGIN_CLIENT_SECRET'),
        'redirect' => env('LINE_LOGIN_REDIRECT'),
    ],

    /**
     * LINE Notify
     */
    'notify' => [
        'personal_access_token' => env('LINE_NOTIFY_PERSONAL_ACCESS_TOKEN')
    ]
];
