<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ValidateLogin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    /**
     * Login Form
     *
     * @return void
     */
    public function index()
    {
        return view('auth.login');
    }

    /**
     * Authenticate login
     *
     * @param ValidateLogin $request
     * @return void
     */
    public function authenticateLogin(ValidateLogin $request)
    {
        return $request->authenticated();
    }

    /**
     * Logout
     *
     * @return void
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
