<?php

namespace Revolution\Line\Providers;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\ServiceProvider;

class MacroServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Http::macro('line', function (?string $endpoint = null): PendingRequest {
            return Http::withToken(config('line.bot.channel_token'))
                ->baseUrl($endpoint ?? 'https://api.line.me');
        });
    }
}
