<?php

namespace Revolution\Line\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Revolution\Line\Contracts\WebhookHandler;
use Revolution\Line\Messaging\Http\Actions\WebhookEventDispatcher;
use Revolution\Line\Messaging\Http\Controllers\WebhookController;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        //Default WebhookHandler
        $this->app->singleton(WebhookHandler::class, WebhookEventDispatcher::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Route::middleware(config('line.bot.middleware'))
            ->domain(config('line.bot.domain'))
            ->group(function () {
                Route::post(config('line.bot.path', 'line/webhook'))
                    ->name(config('line.bot.route', 'line.webhook'))
                    ->uses(WebhookController::class);
            });
    }
}
