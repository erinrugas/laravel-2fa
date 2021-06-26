<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ValidateTwoFactorAuth;
use Illuminate\Http\Request;

class TwoFactorAuthController extends Controller
{
    /**
     * 
     *
     * @return void
     */
    public function index()
    {
        if (session()->has('user_id')) {
            return view('auth.two-factor-auth');
        }

        return redirect()->route('login');
    }

    /**
     * Validate Two Factor Authentication
     *
     * @param ValidateTwoFactorAuth $request
     * @return void
     */
    public function validateTwoFactor(ValidateTwoFactorAuth $request)
    {
        if (strpos($request->two_factor_auth, '-') !== false) {
            return $request->recoveryCode();
        }
        
        return $request->authenticatorCode();
    }
    
}
