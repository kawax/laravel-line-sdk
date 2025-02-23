<?php

namespace Revolution\Line\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Socialite\Facades\Socialite;
use Revolution\Line\Socialite\LineLoginProvider;

class LineSocialiteServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Socialite::extend('line-login', function () {
            return Socialite::buildProvider(LineLoginProvider::class, config('line.login'));
        });
    }
}
