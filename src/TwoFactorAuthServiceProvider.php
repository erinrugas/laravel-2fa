<?php

namespace ErinRugas\Laravel2fa;

use ErinRugas\Laravel2fa\Commands\Installations;
use Illuminate\Support\ServiceProvider;

class TwoFactorAuthServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                Installations::class
            ]);
        }
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
