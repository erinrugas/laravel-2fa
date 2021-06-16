<?php

namespace App\Http\Requests\Auth;

use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
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
        if (! Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->boolean('remember'))) {
            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        return redirect(RouteServiceProvider::HOME);
    }
}
