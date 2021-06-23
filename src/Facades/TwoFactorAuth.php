<?php

namespace ErinRugas\Laravel2fa\Facades;

use Illuminate\Support\Facades\Facade;

class TwoFactorAuth extends Facade
{
    /**
     * Two factor route name
     */
    const REDIRECT_TWO_FACTOR = 'two-factor-authentication';

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'twofactorauth';
    }
}
