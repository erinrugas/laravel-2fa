<?php

namespace ErinRugas\Laravel2fa\Actions;

use ErinRugas\Laravel2fa\Facades\TwoFactorAuth;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;

class GenerateTwoFactorAuth
{

    /**
     * Generate Two Factor Auth
     *
     * @param $user
     * @return void
     */
    public function __invoke($user)
    {
        $user->two_factor_recovery_code = encrypt(
            json_encode(Collection::times(5, function () {
                return TwoFactorAuth::recoveryCode();
            })->all())
        );

        $user->save();
    }
}
