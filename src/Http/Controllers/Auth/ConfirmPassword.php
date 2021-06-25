<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ValidateConfirmPassword;

class ConfirmPassword extends Controller
{

    /**
     * Confirm Password Form
     *
     * @return void
     */
    public function index()
    {
        if (session()->has('confirmed_password')) {
            abort(403);
        }

        return view('auth.confirm-password');
    }

    /**
     * Confirm password
     *
     * @param ValidateConfirmPassword $request
     * @return void
     */
    public function authenticate(ValidateConfirmPassword $request)
    {
        $request->validate();

        $request->session()->put('confirmed_password', now()->format('Y-m-d H:i'));

        return redirect()->route('profile')->with('show_two_factor', 'Show Two Factor Authentication');
    }
}
