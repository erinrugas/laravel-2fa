<?php

namespace App\Http\Requests\Auth;

use App\Providers\RouteServiceProvider;
use ErinRugas\Laravel2fa\Actions\ReplaceRecoveryCode;
use ErinRugas\Laravel2fa\Contracts\Authenticator;
use ErinRugas\Laravel2fa\Facades\TwoFactorAuth;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

class ValidateTwoFactorAuth extends FormRequest
{
    /**
     * Authenticator
     *
     * @var
     */
    protected $authenticator;

    /**
     * Replace Recovery Code
     *
     * @var
     */
    protected $replaceRecoveryCode;

    public function __construct(Authenticator $authenticator, ReplaceRecoveryCode $replaceRecoveryCode)
    {
        $this->authenticator = $authenticator;

        $this->replaceRecoveryCode = $replaceRecoveryCode;
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'two_factor_auth'   => 'required'
        ];
    }

    /**
     * Validate Recovery Code
     *
     * @return
     */
    public function recoveryCode()
    {
        $this->ensureIsNotRateLimited();

        $collections = collect(json_decode(decrypt(session('two_factor_recovery')), TRUE));

        if (in_array($this->two_factor_auth, $collections->toArray())) {

            if ($user = Auth::loginUsingId(session('user_id'), session('remember'))) {
                $replaceRecoveryCode = $this->replaceRecoveryCode;
                $replaceRecoveryCode($user, $this->two_factor_auth, $collections);

                $this->session()->forget(['user_id', 'two_factor_secret', 'two_factor_recovery', 'remember']);
                $this->session()->regenerate();

                return redirect(RouteServiceProvider::HOME);
            }
        }

        /**
         * Set 2 minutes if too many attempts.
         */
        RateLimiter::hit($this->throttleKey(), 120);

        throw ValidationException::withMessages([
            'two_factor_auth' => 'Invalid code, try again.',
        ]);
    }

    /**
     * Validate using Authenticator App
     *
     * @return void
     */
    public function authenticatorCode()
    {
        $this->ensureIsNotRateLimited();

        if ($this->authenticator->verifyKey(decrypt(session('two_factor_secret')), str_replace(' ', '', $this->two_factor_auth))) {
            RateLimiter::clear($this->throttleKey());

            if (Auth::loginUsingId(session('user_id'), session('remember'))) {
                $this->session()->forget(['user_id', 'two_factor_secret', 'two_factor_recovery', 'remember']);
                $this->session()->regenerate();

                return redirect(RouteServiceProvider::HOME);
            }
        }

        /**
         * Set 2 minutes if too many attempts.
         */
        RateLimiter::hit($this->throttleKey(), 120);
        
        throw ValidationException::withMessages([
            'two_factor_auth' => 'Invalid code, try again.',
        ]);
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited()
    {
        if (!RateLimiter::tooManyAttempts($this->throttleKey(), 6)) {
            return;
        }

        event(new Lockout($this));
        
        throw ValidationException::withMessages([
            'two_factor_auth' => TwoFactorAuth::THROTTLE_MESSAGE
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     *
     * @return string
     */
    public function throttleKey()
    {
        return Str::lower($this->input('user_id')) . '|' . $this->ip();
    }
}
