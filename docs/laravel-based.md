# Laravel-based framework

Add a ServiceProvider manually.

## Lumen

`bootstrap/app.php`

```php
$app->register(Revolution\Line\Providers\LineServiceProvider::class);
$app->register(Revolution\Line\Providers\LineSocialiteServiceProvider::class);
$app->register(Revolution\Line\Providers\RouteServiceProvider::class);
$app->register(Revolution\Line\Providers\MacroServiceProvider::class);// Laravel>=7
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
