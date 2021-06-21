<?php 

namespace ErinRugas\Laravel2fa;

use ErinRugas\Laravel2fa\Contracts\Authenticator;
use PragmaRX\Google2FA\Google2FA;

class TwoFactorAuthenticator implements Authenticator
{

    public $google2FA;

    public function __construct(Google2FA $google2FA)
    {
        $this->google2FA  = $google2FA;   
    }

    /**
     * Generate Secret Key
     *
     * @return string
     */
    public function generateSecretKey()
    {
        return $this->google2FA->generateSecretKey();
    }

    /**
     * Verify key of authenticator app
     *
     * @param string $userSecretKey
     * @param string $key
     * @param integer $window
     * @return void
     */
    public function verifyKey($userSecretKey, $key, $window = 4)
    {
        return $this->google2FA->verifyKey($userSecretKey, $key, $window);
    }

    public function getQRCodeUrl($appName, $email, $secretKey)
    {
        return $this->google2FA->getQRCodeUrl($appName, $email, $secretKey);
    }

}