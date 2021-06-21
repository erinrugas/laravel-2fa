<?php

namespace ErinRugas\Laravel2fa\Traits;

use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use ErinRugas\Laravel2fa\Contracts\Authenticator;
use PragmaRX\Google2FA\Google2FA;

trait Has2FA
{

    /**
     * Decrypt Recovery Code
     *
     * @return void
     */
    public function decryptRecoveryCode()
    {
        return !is_null($this->two_factor_recovery_code) ?
            json_decode(decrypt($this->two_factor_recovery_code), TRUE) : null;
    }

    /**
     * Two Factor QR Image
     *
     * @return void
     */
    public function twoFactorQRImg()
    {
        $writer = (new Writer(
            new ImageRenderer(
                new RendererStyle(200),
                new SvgImageBackEnd()
            )
        ))->writeString($this->twoFactorAuthQRCode());

        return $writer;
    }

    /**
     * Two Factor QR Code
     *
     * @return string
     */
    public function twoFactorAuthQRCode()
    {
        $authenticator = app(Authenticator::class);

        return $authenticator->getQRCodeUrl(
            config('app.name'), $this->email, decrypt($this->two_factor_secret_key)
        );
    }
}
