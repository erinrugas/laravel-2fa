<?php

namespace ErinRugas\Laravel2fa\Actions;
class DisableTwoFactorAuth
{

    /**
     * Disable Two Factor Authentication
     *
     * @param $user
     * @return void
     */
    public function __invoke($user)
    {
        $user->two_factor_recovery_code = null;
        $user->two_factor_secret_key = null;
        $user->save();
    }
}
