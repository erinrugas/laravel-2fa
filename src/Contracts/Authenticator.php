<?php

namespace ErinRugas\Laravel2fa\Contracts;

interface Authenticator
{

    /**
     * Generate Secret Key
     *
     * @return string
     */
    public function generateSecretKey();

    /**
     * Verify key of authenticator app
     *
     * @param string $userSecretKey
     * @param string $key
     * @param integer $window
     * @return void
     */
    public function verifyKey($userSecretKey, $key, $window = 4);

    /**
     * Get QR Code Url
     *
     * @return string
     */
    public function getQRCodeUrl($appName, $email, $secretKey);

}