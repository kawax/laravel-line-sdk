# Laravel-based framework

Manually add some ServiceProviders.

## Lumen

`bootstrap/app.php`

```php
$app->register(Revolution\Line\Providers\LineServiceProvider::class);
$app->register(Revolution\Line\Providers\MacroServiceProvider::class);// Laravel>=7

// If you use webhook.
$app->router->group(
    [
        'middleware' => Revolution\Line\Messaging\Http\Middleware\ValidateSignature::class,
    ],
    function ($router) {
        $router->post(
            config('line.bot.path'),
            Revolution\Line\Messaging\Http\Controllers\WebhookController::class
        );
    }
);
```

## Laravel Zero

`config/app.php`

```php
    'providers' => [
        //

        Revolution\Line\Providers\LineServiceProvider::class,
        Revolution\Line\Providers\MacroServiceProvider::class,// Laravel>=7
    ],
```
