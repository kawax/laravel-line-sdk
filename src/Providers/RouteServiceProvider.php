<?php

namespace Revolution\Line\Providers;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Revolution\Line\Messaging\Http\Controllers\WebhookController;
use Revolution\Line\Messaging\Http\Middleware\ValidateSignature;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $middleware = Collection::wrap(config('line.bot.middleware'))
            ->add(ValidateSignature::class)
            ->toArray();

        Route::middleware($middleware)
            ->domain(config('line.bot.domain'))
            ->group(function () {
                Route::post(config('line.bot.path', 'line/webhook'))
                    ->name(config('line.bot.route', 'line.webhook'))
                    ->uses(WebhookController::class);
            });
    }
}
