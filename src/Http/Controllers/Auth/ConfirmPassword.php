<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ValidateConfirmPassword;

class ConfirmPassword extends Controller
{

    public function index()
    {
        // dd(\Carbon\Carbon::parse(session('confirmed_password'))
        //     ->minutes(1)->format('Y-m-d H:i'));
        if (session()->has('confirmed_password')) {
            abort(403);
        }

        return view('auth.confirm-password');

    }
    
    public function confirmed(ValidateConfirmPassword $request)
    {
        $request->authenticate();

        $request->session()->put('confirmed_password', now()->format('Y-m-d H:i'));

        return redirect()->route('profile')->with('show_two_factor', 'Show Two Factor Authentication');
    }

}
