<?php

namespace App\Http\Requests\Auth;

use App\Providers\RouteServiceProvider;
use ErinRugas\Laravel2fa\Facades\TwoFactorAuth;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

class ValidateLogin extends FormRequest
{

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
            'email' => 'required',
            'password'  => 'required'
        ];
    }

    /**
     * Authenticate Login
     *
     * @return void
     */
    public function authenticated()
    {

        $this->ensureIsNotRateLimited();

        $user = $this->guard()
            ->getProvider()
            ->getModel()::where('email', $this->email)
            ->first();

        if (is_null($user) || !Hash::check($this->password, $user->password)) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());

        if (!is_null($user->two_factor_secret_key) && !is_null($user->two_factor_recovery_code)) {
            $this->session()->put('user_id', $user->id);
            $this->session()->put('two_factor_secret', $user->two_factor_secret_key);
            $this->session()->put('two_factor_recovery', $user->two_factor_recovery_code);
            $this->session()->put('remember', $this->boolean('remember'));

            return redirect()->route(TwoFactorAuth::REDIRECT_TWO_FACTOR);
        } else {
            $this->guard()->login($user);
            $this->session()->regenerate();

            return redirect(RouteServiceProvider::HOME);
        }
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

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     *
     * @return string
     */
    public function throttleKey()
    {
        return Str::lower($this->input('email')) . '|' . $this->ip();
    }

    /**
     * Guard Name
     *
     * @param string $guardName
     * @return
     */
    public function guard($guardName = 'web')
    {
        return Auth::guard($guardName);
    }
}
