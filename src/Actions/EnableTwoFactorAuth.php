<?php

namespace ErinRugas\Laravel2fa\Actions;

use ErinRugas\Laravel2fa\Contracts\Authenticator;
use ErinRugas\Laravel2fa\Facades\TwoFactorAuth;
use Illuminate\Database\Eloquent\Collection;

class EnableTwoFactorAuth
{
    /**
     * Authenticator
     *
     * @var [type]
     */
    protected $authenticator;

    /**
     * Constructor
     *
     * @param Authenticator $authenticator
     */
    public function __construct(Authenticator $authenticator)
    {
        $this->authenticator = $authenticator;
    }

    /**
     * Enable Two Factor Authentication
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

        $user->two_factor_secret_key = encrypt($this->authenticator->generateSecretKey());
        $user->save();
    }
}
