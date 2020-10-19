<?php

namespace Revolution\Line\Providers;

use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;
use LINE\LINEBot;
use LINE\LINEBot\HTTPClient;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;
use Revolution\Line\Contracts\BotFactory;
use Revolution\Line\Contracts\NotifyFactory;
use Revolution\Line\Contracts\WebhookHandler;
use Revolution\Line\Messaging\BotClient;
use Revolution\Line\Messaging\Http\Actions\WebhookEventDispatcher;
use Revolution\Line\Notifications\LineNotifyClient;

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

        $this->registerBot();

        $this->registerNotify();

        $this->registerWebhookHandler();
    }

    /**
     * Bot.
     *
     * @return void
     */
    protected function registerBot()
    {
        $this->app->singleton(HTTPClient::class, function ($app) {
            return new CurlHTTPClient(config('line.bot.channel_token'));
        });

        $this->app->singleton(LINEBot::class, function ($app) {
            return new LINEBot($app->make(HTTPClient::class), [
                'channelSecret' => config('line.bot.channel_secret'),
            ]);
        });

        $this->app->singleton(BotFactory::class, BotClient::class);
    }

    /**
     * Notify.
     *
     * @return void
     */
    protected function registerNotify()
    {
        $this->app->singleton(NotifyFactory::class, function ($app) {
            return new LineNotifyClient($app->make(Client::class));
        });
    }

    /**
     * Default WebhookHandler.
     *
     * @return void
     */
    protected function registerWebhookHandler()
    {
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
    }

    /**
     * Configure publishing for the package.
     *
     * @return void
     */
    protected function configurePublishing()
    {
        if (! $this->app->runningInConsole()) {
            return;
        }

        $this->publishes([
            __DIR__.'/../../config/line.php' => $this->app->configPath('line.php'),
        ], 'line-config');

        $this->publishes([
            __DIR__.'/../../stubs/listeners' => $this->app->path('Listeners'),
        ], 'line-listeners-all');

        $this->publishes([
            __DIR__.'/../../stubs/listeners/Message' => $this->app->path('Listeners/Message'),
        ], 'line-listeners-message');
    }
}
