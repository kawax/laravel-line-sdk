<?php

namespace Revolution\Line\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Socialite\Facades\Socialite;
use Revolution\Line\Socialite\LineLoginProvider;
use Revolution\Line\Socialite\LineNotifyProvider;

class LineSocialiteServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Socialite::extend('line-login', function () {
            return Socialite::buildProvider(LineLoginProvider::class, config('line.login'));
        });

        $this->notify();
    }

    /**
     * @deprecated
     */
    protected function notify(): void
    {
        Socialite::extend('line-notify', function () {
            return Socialite::buildProvider(LineNotifyProvider::class, config('line.notify'));
        });
    }
}
