<?php

namespace ErinRugas\Laravel2fa\Actions;

use ErinRugas\Laravel2fa\Facades\TwoFactorAuth;

class ReplaceRecoveryCode
{
    /**
     * Replace Recovery Code
     *
     * @param $user
     * @param $code
     * @param $recoveryCodeCollections
     * @return void
     */
    public function __invoke($user, $code ,$recoveryCodeCollections)
    {
        $replace = $recoveryCodeCollections->replace(
            [
                array_keys(
                    $recoveryCodeCollections->toArray(),
                    $code
                )[0] => TwoFactorAuth::recoveryCode()
            ]
        );

        $user->two_factor_recovery_code = encrypt(json_encode($replace));
        $user->save();
    }
}