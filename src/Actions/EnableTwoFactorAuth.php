<?php

namespace ErinRugas\Laravel2fa\Actions;

use ErinRugas\Laravel2fa\Facades\TwoFactorAuth;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;
use PragmaRX\Google2FA\Google2FA;

class EnableTwoFactorAuth
{

    /**
     * Enable Two Factor Authentication
     *
     * @param $user
     * @return void
     */
    public function __invoke($user)
    {
        $google2Fa = new Google2FA();

        $user->two_factor_recovery_code = encrypt(
            json_encode(Collection::times(5, function () {
                return TwoFactorAuth::recoveryCode();
            })->all())
        );

        $user->two_factor_secret_key = encrypt($google2Fa->generateSecretKey());
        $user->save();
    }
}
