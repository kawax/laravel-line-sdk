<?php

namespace Revolution\Line\Providers;

use Illuminate\Http\Client\Factory;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\ServiceProvider;
use LINE\LINEBot;

class MacroServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (! class_exists(Factory::class)) {
            return; // @codeCoverageIgnore
        }

        Http::macro('line', function (string $endpoint = null): PendingRequest {
            return Http::withToken(config('line.bot.channel_token'))
                ->baseUrl($endpoint ?? LINEBot::DEFAULT_ENDPOINT_BASE);
        });
    }
}
