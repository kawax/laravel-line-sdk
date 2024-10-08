<?php

namespace Revolution\Line\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Revolution\Line\Messaging\Http\Controllers\WebhookController;
use Revolution\Line\Messaging\Http\Middleware\ValidateSignature;

class RouteServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Route::middleware(config('line.bot.middleware'))
            ->domain(config('line.bot.domain'))
            ->group(function () {
                Route::post(config('line.bot.path', 'line/webhook'))
                    ->name(config('line.bot.route', 'line.webhook'))
                    ->middleware(ValidateSignature::class)
                    ->uses(WebhookController::class);
            });
    }
}
