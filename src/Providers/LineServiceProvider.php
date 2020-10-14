<?php

namespace Revolution\Line\Providers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Laravel\Socialite\Facades\Socialite;
use LINE\LINEBot;
use LINE\LINEBot\HTTPClient;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;
use Revolution\Line\Contracts\BotFactory;
use Revolution\Line\Contracts\WebhookHandler;
use Revolution\Line\Messaging\BotClient;
use Revolution\Line\Messaging\Http\Actions\WebhookEventDispatcher;
use Revolution\Line\Messaging\Http\Controllers\WebhookController;
use Revolution\Line\Socialite\LineLoginProvider;

class LineServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../../config/line.php',
            'line'
        );

        $this->app->singleton(HTTPClient::class, function () {
            return new CurlHTTPClient(config('line.bot.channel_token'));
        });

        $this->app->singleton(LINEBot::class, function ($app) {
            return new LINEBot($app->make(HTTPClient::class), [
                'channelSecret' => config('line.bot.channel_secret')
            ]);
        });

        $this->app->singleton(BotFactory::class, BotClient::class);

        // Default WebhookHandler
        $this->app->singleton(WebhookHandler::class, WebhookEventDispatcher::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->configurePublishing();
        $this->configureRoutes();
        $this->configureSocialite();
        $this->configureMacros();
    }

    /**
     * Configure publishing for the package.
     *
     * @return void
     */
    protected function configurePublishing()
    {
        if (!$this->app->runningInConsole()) {
            return;
        }

        $this->publishes([
            __DIR__.'/../../config/line.php' => config_path('line.php')
        ], 'line-config');

        $this->publishes([
            __DIR__.'/../../stubs/listeners' => app_path('Listeners')
        ], 'line-listeners-all');

        $this->publishes([
            __DIR__.'/../../stubs/listeners/Message' => app_path('Listeners/Message')
        ], 'line-listeners-message');
    }

    /**
     * Configure the routes.
     *
     * @return void
     */
    protected function configureRoutes()
    {
        Route::middleware(config('line.bot.middleware'))
            ->domain(config('line.bot.domain'))
            ->group(function () {
                Route::post(config('line.bot.path', 'line/webhook'))
                    ->name(config('line.bot.route', 'line.webhook'))
                    ->uses(WebhookController::class);
            });
    }

    /**
     * Configure Socialite.
     *
     * @return void
     */
    protected function configureSocialite()
    {
        Socialite::extend('line-login', function () {
            return Socialite::buildProvider(LineLoginProvider::class, config('line.login'));
        });
    }

    /**
     * Configure macros.
     *
     * @return void
     */
    protected function configureMacros()
    {
        if (!class_exists(Http::class)) {
            return;
        }

        Http::macro('line', function (string $endpoint = null) {
            return Http::withToken(config('line.bot.channel_token'))
                ->baseUrl($endpoint ?? LINEBot::DEFAULT_ENDPOINT_BASE);
        });
    }
}
