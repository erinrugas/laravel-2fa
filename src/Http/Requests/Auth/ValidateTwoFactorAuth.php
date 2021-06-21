<?php

namespace App\Http\Requests\Auth;

use App\Providers\RouteServiceProvider;
use ErinRugas\Laravel2fa\Actions\ReplaceRecoveryCode;
use ErinRugas\Laravel2fa\Contracts\Authenticator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class ValidateTwoFactorAuth extends FormRequest
{

    protected $authenticator;

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
        $collections = collect(json_decode(decrypt(session('two_factor_recovery')), TRUE));
        
        if (in_array($this->two_factor_auth, $collections->toArray())) {

            if ($user = Auth::loginUsingId(session('user_id'), session('remember'))) {
                $replaceRecoveryCode = $this->replaceRecoveryCode;
                $replaceRecoveryCode($user, $this->two_factor_auth ,$collections);
                
                $this->session()->forget(['user_id', 'two_factor_secret', 'two_factor_recovery', 'remember']);
                $this->session()->regenerate();
                
                return redirect(RouteServiceProvider::HOME);
            }
        }

        throw ValidationException::withMessages([
            'two_factor_auth' => 'Invalid code, try again',
        ]);
    }

    /**
     * Validate using Authenticator App
     *
     * @return void
     */
    public function authenticator()
    {
        if ($this->authenticator->verifyKey(decrypt(session('two_factor_secret')), str_replace(' ', '', $this->two_factor_auth))) {

            if (Auth::loginUsingId(session('user_id'), session('remember'))) {
                $this->session()->forget(['user_id', 'two_factor_secret', 'two_factor_recovery', 'remember']);
                $this->session()->regenerate();

                return redirect(RouteServiceProvider::HOME);
            }
        }
        throw ValidationException::withMessages([
            'two_factor_auth' => 'Invalid code, try again.',
        ]);
    }
}
