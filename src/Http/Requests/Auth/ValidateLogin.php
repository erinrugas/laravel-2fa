<?php

namespace App\Http\Requests\Auth;

use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

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
        $model = $this->guard()->getProvider()->getModel();

        $user = $model::where('email', $this->email)->first();

        if (!Hash::check($this->password, $user->password)) {

            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        if (!is_null($user->two_factor_secret_key) && !is_null($user->two_factor_recovery_code)) {
            $this->session()->put('user_id', $user->id);
            $this->session()->put('two_factor_secret', $user->two_factor_secret_key);
            $this->session()->put('two_factor_recovery', $user->two_factor_recovery_code);
            $this->session()->put('remember', $this->boolean('remember'));

            return redirect()->route('two-factor-authentication');
        } else {
            $this->guard()->login($user);
            $this->session()->regenerate();

            return redirect(RouteServiceProvider::HOME);
        }
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
