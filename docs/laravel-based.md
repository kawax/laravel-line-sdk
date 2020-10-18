# Laravel-based framework

Add a ServiceProvider manually.

## Lumen

`bootstrap/app.php`

```php
$app->register(Revolution\Line\Providers\LineServiceProvider::class);
```

## Laravel Zero

`config/app.php`

```php
    'providers' => [
        //

        Revolution\Line\Providers\LineServiceProvider::class,
    ],
```
