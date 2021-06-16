<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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

    /**
     * Register User
     *
     * @param Request $request
     * @return void
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required|max:255',
            'email' => "required|email|unique:users,email|max:255",
            'password'  => 'required|min:8'
        ]);

        $user = User::create([
            'name'  => $request->name,
            'email' => strtolower($request->email),
            'password'  => Hash::make($request->password)
        ]);

        Auth::login($user);

        $request->session()->regenerate();

        return redirect(RouteServiceProvider::HOME);
    }
}
