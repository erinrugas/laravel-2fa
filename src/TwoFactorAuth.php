<?php

namespace ErinRugas\Laravel2fa;

use Illuminate\Support\Str;
class TwoFactorAuth
{

    /**
     * Generate Recovery Code
     *
     * @return string
     */
    public function recoveryCode()
    {
        return Str::random(6) .'-'. Str::random(6);
    }

}
