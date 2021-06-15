<?php

namespace ErinRugas\Laravel2fa;

use Illuminate\Support\ServiceProvider;

class TwoFactorAuthServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {

    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->app->singleton('twofactorauth', function () {
            return new TwoFactorAuth;
        });
    }
}
