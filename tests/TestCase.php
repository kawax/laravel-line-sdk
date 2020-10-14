<?php

namespace Tests;

use Laravel\Socialite\SocialiteServiceProvider;
use Revolution\Line\Facades\Bot;
use Revolution\Line\Providers\LineServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
    /**
     * Load package service provider.
     *
     * @param  \Illuminate\Foundation\Application  $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            LineServiceProvider::class,
            SocialiteServiceProvider::class,
        ];
    }

    /**
     * Load package alias.
     *
     * @param  \Illuminate\Foundation\Application  $app
     *
     * @return array
     */
    protected function getPackageAliases($app)
    {
        return [
            //'LINE' => Bot::class,
        ];
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     *
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        //
    }
}
