<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

class RegisterController extends Controller
{
    /**
     * Register Form
     *
     * @return void
     */
    public function index()
    {
        return view('auth.register');
    }
}
